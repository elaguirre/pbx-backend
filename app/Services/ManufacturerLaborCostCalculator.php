<?php

namespace App\Services;

use App\Enums\ManufacturingFollowUpResult;
use App\Models\ManufacturingFollowUp;
use App\Models\ManufacturerOrderPiece;
use App\Models\ManufacturerPieceCost;
use App\Models\OrderPiece;
use App\Models\OrderPieceStatus;
use App\Models\ProductionOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ManufacturerLaborCostCalculator
{
    /** @var array<int, array<int, float>> */
    protected array $unitPricesByManufacturer = [];

    /** @return array<int, float> piece_id => unit price */
    public function unitPricesByPieceForManufacturer(int $manufacturerId): array
    {
        if (isset($this->unitPricesByManufacturer[$manufacturerId])) {
            return $this->unitPricesByManufacturer[$manufacturerId];
        }

        $prices = ManufacturerPieceCost::query()
            ->where('manufacturer_id', $manufacturerId)
            ->pluck('price', 'piece_id')
            ->map(fn ($price) => (float) $price)
            ->all();

        return $this->unitPricesByManufacturer[$manufacturerId] = $prices;
    }

    public function lineLaborCost(int $manufacturerId, int $pieceId, float $quantity): ?float
    {
        $unit = $this->unitPricesByPieceForManufacturer($manufacturerId)[$pieceId] ?? null;

        if ($unit === null) {
            return null;
        }

        return round($unit * $quantity, 2);
    }

    public function appendManufacturerOrderPieceLaborCosts(mixed $resolved): mixed
    {
        $items = $this->collectModels($resolved);

        if ($items->isEmpty()) {
            return $resolved;
        }

        $productionOrderIds = $items->pluck('production_order_id')->unique()->values()->all();
        $manufacturerByOrderId = ProductionOrder::query()
            ->whereIn('id', $productionOrderIds)
            ->pluck('manufacturer_id', 'id')
            ->all();

        $orderPieceIds = $items->pluck('order_piece_id')->unique()->values()->all();
        $pieceIdByOrderPieceId = OrderPiece::query()
            ->whereIn('id', $orderPieceIds)
            ->pluck('piece_id', 'id')
            ->all();

        foreach ($items as $row) {
            if ($row->relationLoaded('orderPiece') && $row->orderPiece) {
                $pieceIdByOrderPieceId[$row->order_piece_id] = $row->orderPiece->piece_id;
            }
        }

        return $this->mapResolved($resolved, function (Model $row) use ($manufacturerByOrderId, $pieceIdByOrderPieceId) {
            /** @var ManufacturerOrderPiece $row */
            $manufacturerId = $manufacturerByOrderId[$row->production_order_id] ?? null;
            $pieceId = $pieceIdByOrderPieceId[$row->order_piece_id] ?? null;
            $unit = null;
            $line = null;

            if ($manufacturerId && $pieceId) {
                $unit = $this->unitPricesByPieceForManufacturer((int) $manufacturerId)[$pieceId] ?? null;
                $line = $unit !== null
                    ? $this->lineLaborCost((int) $manufacturerId, (int) $pieceId, (float) $row->quantity)
                    : null;
            }

            $row->setAttribute('labor_unit_price', $unit !== null ? round($unit, 2) : null);
            $row->setAttribute('labor_cost', $line);

            return $row;
        });
    }

    public function appendProductionOrderLaborCosts(mixed $resolved): mixed
    {
        $orders = $this->collectModels($resolved);

        if ($orders->isEmpty()) {
            return $resolved;
        }

        $orderIds = $orders->pluck('id')->all();
        $manufacturerByOrderId = $orders->pluck('manufacturer_id', 'id')->all();
        $assignments = ManufacturerOrderPiece::query()
            ->whereIn('production_order_id', $orderIds)
            ->get(['id', 'production_order_id', 'order_piece_id', 'quantity']);

        $pieceIdByOrderPieceId = OrderPiece::query()
            ->whereIn('id', $assignments->pluck('order_piece_id')->unique()->values()->all())
            ->pluck('piece_id', 'id')
            ->all();

        $totalsByOrderId = array_fill_keys($orderIds, 0.0);
        $hasCostByOrderId = array_fill_keys($orderIds, false);

        foreach ($assignments as $assignment) {
            $manufacturerId = (int) ($manufacturerByOrderId[$assignment->production_order_id] ?? 0);
            $pieceId = (int) ($pieceIdByOrderPieceId[$assignment->order_piece_id] ?? 0);

            if (! $manufacturerId || ! $pieceId) {
                continue;
            }

            $line = $this->lineLaborCost($manufacturerId, $pieceId, (float) $assignment->quantity);

            if ($line !== null) {
                $totalsByOrderId[$assignment->production_order_id] += $line;
                $hasCostByOrderId[$assignment->production_order_id] = true;
            }
        }

        return $this->mapResolved($resolved, function (Model $order) use ($totalsByOrderId, $hasCostByOrderId) {
            $orderId = $order->getKey();
            $total = $hasCostByOrderId[$orderId] ?? false
                ? round($totalsByOrderId[$orderId], 2)
                : null;

            if ($total !== null && $total <= 0) {
                $total = null;
            }

            $order->setAttribute('labor_cost', $total);

            return $order;
        });
    }

    public function appendProductionOrderCompletionProgress(mixed $resolved): mixed
    {
        $orders = $this->collectModels($resolved);

        if ($orders->isEmpty()) {
            return $resolved;
        }

        $orderIds = $orders->pluck('id')->all();
        $assignments = ManufacturerOrderPiece::query()
            ->whereIn('production_order_id', $orderIds)
            ->get(['id', 'production_order_id', 'quantity']);

        [$totalQtyByOrderId, $completedQtyByOrderId] = $this->completionTotalsFromFollowUp(
            $assignments,
            fn (ManufacturerOrderPiece $assignment) => $assignment->production_order_id,
        );

        return $this->mapResolved($resolved, function (Model $order) use ($totalQtyByOrderId, $completedQtyByOrderId) {
            $orderId = $order->getKey();
            $progress = $this->completionProgressAttributes(
                (float) ($totalQtyByOrderId[$orderId] ?? 0),
                (float) ($completedQtyByOrderId[$orderId] ?? 0),
            );

            $order->setAttribute('completion_progress', $progress);

            return $order;
        });
    }

    public function appendProductionBatchCompletionProgress(mixed $resolved): mixed
    {
        $batches = $this->collectModels($resolved);

        if ($batches->isEmpty()) {
            return $resolved;
        }

        $batchIds = $batches->pluck('id')->all();
        $assignments = ManufacturerOrderPiece::query()
            ->join(
                'production_orders',
                'production_orders.id',
                '=',
                'manufacturer_order_pieces.production_order_id',
            )
            ->whereIn('production_orders.production_batch_id', $batchIds)
            ->get([
                'manufacturer_order_pieces.id',
                'manufacturer_order_pieces.order_piece_id',
                'manufacturer_order_pieces.quantity',
                'production_orders.production_batch_id',
            ]);

        [$totalQtyByBatchId, $completedQtyByBatchId] = $this->completionTotalsFromPackableStatus(
            $assignments,
            fn (ManufacturerOrderPiece $assignment) => $assignment->production_batch_id,
        );

        return $this->mapResolved($resolved, function (Model $batch) use ($totalQtyByBatchId, $completedQtyByBatchId) {
            $batchId = $batch->getKey();
            $progress = $this->completionProgressAttributes(
                (float) ($totalQtyByBatchId[$batchId] ?? 0),
                (float) ($completedQtyByBatchId[$batchId] ?? 0),
            );

            $batch->setAttribute('completion_progress', $progress);

            return $batch;
        });
    }

    /**
     * Avance de orden de producción: piezas terminadas en seguimiento de manufactura.
     *
     * @param  Collection<int, ManufacturerOrderPiece>  $assignments
     * @return array{array<int|string, float>, array<int|string, float>}
     */
    protected function completionTotalsFromFollowUp(Collection $assignments, callable $groupKeyResolver): array
    {
        $totalQtyByGroup = [];
        $completedQtyByGroup = [];

        if ($assignments->isEmpty()) {
            return [$totalQtyByGroup, $completedQtyByGroup];
        }

        $finishedByAssignmentId = ManufacturingFollowUp::query()
            ->whereIn('manufacturer_order_piece_id', $assignments->pluck('id')->all())
            ->where('result', ManufacturingFollowUpResult::CompletedPieces)
            ->groupBy('manufacturer_order_piece_id')
            ->selectRaw('manufacturer_order_piece_id, SUM(quantity) as total')
            ->pluck('total', 'manufacturer_order_piece_id')
            ->map(fn ($total) => (float) $total)
            ->all();

        foreach ($assignments as $assignment) {
            $groupId = $groupKeyResolver($assignment);

            if ($groupId === null) {
                continue;
            }

            $assigned = (float) $assignment->quantity;
            $finished = (float) ($finishedByAssignmentId[$assignment->getKey()] ?? 0);

            $totalQtyByGroup[$groupId] = ($totalQtyByGroup[$groupId] ?? 0) + $assigned;
            $completedQtyByGroup[$groupId] = ($completedQtyByGroup[$groupId] ?? 0) + min($finished, $assigned);
        }

        return [$totalQtyByGroup, $completedQtyByGroup];
    }

    /**
     * Avance de lote de producción: piezas en status empaquetable o posterior.
     *
     * @param  Collection<int, ManufacturerOrderPiece>  $assignments
     * @return array{array<int|string, float>, array<int|string, float>}
     */
    protected function completionTotalsFromPackableStatus(Collection $assignments, callable $groupKeyResolver): array
    {
        $totalQtyByGroup = [];
        $completedQtyByGroup = [];

        if ($assignments->isEmpty()) {
            return [$totalQtyByGroup, $completedQtyByGroup];
        }

        $packableOrBeyondStatusIds = OrderPieceStatus::packableOrBeyondStatusIds();
        $packableOrderPieceIds = $packableOrBeyondStatusIds === []
            ? []
            : OrderPiece::query()
                ->whereIn('id', $assignments->pluck('order_piece_id')->unique()->values()->all())
                ->whereIn('order_piece_status_id', $packableOrBeyondStatusIds)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->all();

        foreach ($assignments as $assignment) {
            $groupId = $groupKeyResolver($assignment);

            if ($groupId === null) {
                continue;
            }

            $assigned = (float) $assignment->quantity;

            $totalQtyByGroup[$groupId] = ($totalQtyByGroup[$groupId] ?? 0) + $assigned;

            if (in_array((int) $assignment->order_piece_id, $packableOrderPieceIds, true)) {
                $completedQtyByGroup[$groupId] = ($completedQtyByGroup[$groupId] ?? 0) + $assigned;
            }
        }

        return [$totalQtyByGroup, $completedQtyByGroup];
    }

    /** @return array{percent: float, bar_class: string, track_class: string, text_class: string}> */
    protected function completionProgressAttributes(float $totalQuantity, float $completedQuantity): array
    {
        if ($totalQuantity <= 0) {
            return [
                'percent' => 0.0,
                'bar_class' => 'bg-slate-400',
                'track_class' => 'bg-slate-100',
                'text_class' => 'text-slate-500',
            ];
        }

        $percent = round(($completedQuantity / $totalQuantity) * 100, 2);

        if ($percent >= 95) {
            return [
                'percent' => $percent,
                'bar_class' => 'bg-green-500',
                'track_class' => 'bg-green-100',
                'text_class' => 'text-green-700',
            ];
        }

        if ($percent < 30) {
            return [
                'percent' => $percent,
                'bar_class' => 'bg-red-500',
                'track_class' => 'bg-red-100',
                'text_class' => 'text-red-700',
            ];
        }

        return [
            'percent' => $percent,
            'bar_class' => 'bg-amber-500',
            'track_class' => 'bg-amber-100',
            'text_class' => 'text-amber-700',
        ];
    }

    protected function mapResolved(mixed $resolved, callable $callback): mixed
    {
        if ($resolved instanceof LengthAwarePaginator) {
            $resolved->setCollection(
                $resolved->getCollection()->map($callback)
            );

            return $resolved;
        }

        if ($resolved instanceof Collection) {
            return $resolved->map($callback);
        }

        if (is_array($resolved)) {
            return array_map($callback, $resolved);
        }

        if ($resolved instanceof Model) {
            return $callback($resolved);
        }

        return $resolved;
    }

    protected function collectModels(mixed $resolved): Collection
    {
        if ($resolved instanceof LengthAwarePaginator) {
            return $resolved->getCollection();
        }

        if ($resolved instanceof Collection) {
            return $resolved;
        }

        if (is_array($resolved)) {
            return collect($resolved);
        }

        if ($resolved instanceof Model) {
            return collect([$resolved]);
        }

        return collect();
    }
}
