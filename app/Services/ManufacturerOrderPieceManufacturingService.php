<?php

namespace App\Services;

use App\Enums\ManufacturingFollowUpResult;
use App\Enums\ManufacturerOrderPieceStatus;
use App\Models\ManufacturingFollowUp;
use App\Models\ManufacturerOrderPiece;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ManufacturerOrderPieceManufacturingService
{
    /** @return array<int, float> */
    public function completedPiecesQuantitiesByAssignmentIds(array $assignmentIds): array
    {
        if ($assignmentIds === []) {
            return [];
        }

        return ManufacturingFollowUp::query()
            ->whereIn('manufacturer_order_piece_id', $assignmentIds)
            ->where('result', ManufacturingFollowUpResult::CompletedPieces)
            ->groupBy('manufacturer_order_piece_id')
            ->selectRaw('manufacturer_order_piece_id, SUM(quantity) as total')
            ->pluck('total', 'manufacturer_order_piece_id')
            ->map(fn ($total) => (float) $total)
            ->all();
    }

    public function resolveStatus(float $assignedQuantity, float $finishedQuantity): ManufacturerOrderPieceStatus
    {
        if ($finishedQuantity <= 0.0001) {
            return ManufacturerOrderPieceStatus::Pending;
        }

        if ($finishedQuantity >= $assignedQuantity - 0.0001) {
            return ManufacturerOrderPieceStatus::Completed;
        }

        return ManufacturerOrderPieceStatus::InProduction;
    }

    public function syncAssignmentStatus(ManufacturerOrderPiece $assignment, ?float $finishedQuantity = null): void
    {
        $finishedQuantity ??= (float) (
            $this->completedPiecesQuantitiesByAssignmentIds([$assignment->getKey()])[$assignment->getKey()] ?? 0
        );

        $newStatus = $this->resolveStatus((float) $assignment->quantity, $finishedQuantity);

        if ($assignment->status === $newStatus) {
            return;
        }

        $assignment->update(['status' => $newStatus]);
    }

    public function appendManufacturingAttributes(mixed $resolved): mixed
    {
        $items = $this->collectModels($resolved);

        if ($items->isEmpty()) {
            return $resolved;
        }

        $assignmentIds = $items->pluck('id')->all();
        $finishedByAssignmentId = $this->completedPiecesQuantitiesByAssignmentIds($assignmentIds);

        return $this->mapResolved($resolved, function (Model $row) use ($finishedByAssignmentId) {
            /** @var ManufacturerOrderPiece $row */
            $finished = (float) ($finishedByAssignmentId[$row->getKey()] ?? 0);

            $row->setAttribute('finished_quantity', round($finished, 4));

            $newStatus = $this->resolveStatus((float) $row->quantity, $finished);

            if ($row->status !== $newStatus) {
                ManufacturerOrderPiece::query()
                    ->whereKey($row->getKey())
                    ->update(['status' => $newStatus->value]);
                $row->setAttribute('status', $newStatus);
            }

            return $row;
        });
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
