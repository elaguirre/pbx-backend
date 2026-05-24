<?php

namespace App\Services;

use App\Models\ManufacturerOrderPiece;
use App\Models\OrderPiece;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class OrderPieceAssignmentCalculator
{
    /** @return array<int, float> */
    public function assignedQuantitiesByOrderPieceId(
        array $orderPieceIds,
        ?int $excludeAssignmentId = null,
        ?int $productionOrderId = null,
    ): array {
        if ($orderPieceIds === []) {
            return [];
        }

        $query = ManufacturerOrderPiece::query()
            ->whereIn('order_piece_id', $orderPieceIds)
            ->selectRaw('order_piece_id, SUM(quantity) as assigned_quantity')
            ->groupBy('order_piece_id');

        if ($productionOrderId) {
            $query->where('production_order_id', $productionOrderId);
        }

        if ($excludeAssignmentId) {
            $query->where('id', '!=', $excludeAssignmentId);
        }

        return $query
            ->pluck('assigned_quantity', 'order_piece_id')
            ->map(fn ($qty) => (float) $qty)
            ->all();
    }

    /** @return array<int, bool> */
    public function orderPieceIdsInProductionOrder(int $productionOrderId): array
    {
        return ManufacturerOrderPiece::query()
            ->where('production_order_id', $productionOrderId)
            ->pluck('order_piece_id')
            ->flip()
            ->map(fn () => true)
            ->all();
    }

    public function appendAssignmentTotals(mixed $resolved, ?int $productionOrderId = null, ?int $editingAssignmentId = null): mixed
    {
        $items = $this->collectModels($resolved);

        if ($items->isEmpty()) {
            return $resolved;
        }

        $orderPieceIds = $items->pluck('id')->all();
        $assignedGlobally = $this->assignedQuantitiesByOrderPieceId($orderPieceIds, $editingAssignmentId);
        $assignedInProductionOrder = $productionOrderId
            ? $this->assignedQuantitiesByOrderPieceId($orderPieceIds, $editingAssignmentId, $productionOrderId)
            : [];
        $inCurrentOrder = $productionOrderId
            ? $this->orderPieceIdsInProductionOrder($productionOrderId)
            : [];

        return $this->mapResolved($resolved, function (Model $row) use (
            $assignedGlobally,
            $assignedInProductionOrder,
            $inCurrentOrder,
            $productionOrderId,
        ) {
            /** @var OrderPiece $row */
            $total = (float) $row->quantity;
            $assignedGlobal = (float) ($assignedGlobally[$row->getKey()] ?? 0);
            $assignedInOrder = (float) ($assignedInProductionOrder[$row->getKey()] ?? 0);
            $remaining = $productionOrderId
                ? max(0, round($total - $assignedInOrder, 4))
                : max(0, round($total - $assignedGlobal, 4));

            $row->setAttribute('assigned_quantity', $assignedGlobal > 0 ? round($assignedGlobal, 4) : 0);
            $row->setAttribute(
                'assigned_quantity_in_production_order',
                $assignedInOrder > 0 ? round($assignedInOrder, 4) : 0,
            );
            $row->setAttribute('remaining_quantity', $remaining);
            $row->setAttribute(
                'assigned_in_production_order',
                isset($inCurrentOrder[$row->getKey()]),
            );

            return $row;
        });
    }

    public function availableQuantityForAssignment(
        OrderPiece $orderPiece,
        float $requestedQuantity,
        ?int $excludeAssignmentId = null,
    ): ?float {
        $assigned = $this->assignedQuantitiesByOrderPieceId([$orderPiece->getKey()], $excludeAssignmentId);
        $already = (float) ($assigned[$orderPiece->getKey()] ?? 0);
        $remaining = (float) $orderPiece->quantity - $already;

        return $requestedQuantity <= $remaining + 0.0001 ? $remaining : null;
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
