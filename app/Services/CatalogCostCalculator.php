<?php

namespace App\Services;

use App\Models\MaterialSupplier;
use App\Models\PieceMaterial;
use App\Models\ProductPiece;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CatalogCostCalculator
{
    /** @var array<int, float|null> */
    protected array $materialUnitCosts = [];

    public function bestUnitPricesByMaterialId(): array
    {
        if ($this->materialUnitCosts !== []) {
            return $this->materialUnitCosts;
        }

        $pricesByMaterial = [];

        MaterialSupplier::query()
            ->with('latestPrice')
            ->get()
            ->groupBy('material_id')
            ->each(function ($suppliers, $materialId) use (&$pricesByMaterial) {
                $best = $suppliers
                    ->map(fn ($ms) => $ms->latestPrice?->price)
                    ->filter(fn ($price) => $price !== null)
                    ->min();

                $pricesByMaterial[(int) $materialId] = $best !== null ? (float) $best : null;
            });

        return $this->materialUnitCosts = $pricesByMaterial;
    }

    public function pieceUnitCost(int $pieceId, ?array $bestPrices = null): ?float
    {
        $bestPrices ??= $this->bestUnitPricesByMaterialId();

        $total = (float) PieceMaterial::query()
            ->where('piece_id', $pieceId)
            ->get()
            ->sum(function (PieceMaterial $row) use ($bestPrices) {
                $unit = $bestPrices[$row->material_id] ?? null;

                if ($unit === null) {
                    return 0;
                }

                return $unit * (float) $row->quantity;
            });

        return $total > 0 ? round($total, 2) : null;
    }

    /** @param list<int> $pieceIds */
    public function pieceUnitCostsByPieceId(array $pieceIds): array
    {
        if ($pieceIds === []) {
            return [];
        }

        $bestPrices = $this->bestUnitPricesByMaterialId();
        $costs = array_fill_keys($pieceIds, 0.0);

        PieceMaterial::query()
            ->whereIn('piece_id', $pieceIds)
            ->get()
            ->each(function (PieceMaterial $row) use ($bestPrices, &$costs) {
                $unit = $bestPrices[$row->material_id] ?? null;

                if ($unit !== null) {
                    $costs[$row->piece_id] += $unit * (float) $row->quantity;
                }
            });

        return collect($costs)
            ->map(fn ($cost) => $cost > 0 ? round((float) $cost, 2) : null)
            ->all();
    }

    /** @param list<int> $productIds */
    public function productCostsByProductId(array $productIds): array
    {
        if ($productIds === []) {
            return [];
        }

        $productPieces = ProductPiece::query()->whereIn('product_id', $productIds)->get();
        $pieceIds = $productPieces->pluck('piece_id')->unique()->values()->all();
        $pieceCosts = $this->pieceUnitCostsByPieceId($pieceIds);
        $costs = array_fill_keys($productIds, 0.0);

        foreach ($productPieces as $row) {
            $pieceCost = $pieceCosts[$row->piece_id] ?? null;

            if ($pieceCost !== null) {
                $costs[$row->product_id] += $pieceCost * (float) $row->quantity;
            }
        }

        return collect($costs)
            ->map(fn ($cost) => $cost > 0 ? round((float) $cost, 2) : null)
            ->all();
    }

    public function appendMaterialCosts(mixed $resolved): mixed
    {
        $bestPrices = $this->bestUnitPricesByMaterialId();

        return $this->mapResolved($resolved, function (Model $material) use ($bestPrices) {
            $unit = $bestPrices[$material->getKey()] ?? null;
            $material->setAttribute('cost', $unit !== null ? round($unit, 2) : null);

            return $material;
        });
    }

    public function appendPieceCosts(mixed $resolved): mixed
    {
        $items = $this->collectModels($resolved);
        $costs = $this->pieceUnitCostsByPieceId($items->pluck('id')->all());

        return $this->mapResolved($resolved, function (Model $piece) use ($costs) {
            $piece->setAttribute('cost', $costs[$piece->getKey()] ?? null);

            return $piece;
        });
    }

    public function appendProductCosts(mixed $resolved): mixed
    {
        $items = $this->collectModels($resolved);
        $costs = $this->productCostsByProductId($items->pluck('id')->all());

        return $this->mapResolved($resolved, function (Model $product) use ($costs) {
            $product->setAttribute('cost', $costs[$product->getKey()] ?? null);

            return $product;
        });
    }

    public function appendProductPieceCosts(mixed $resolved): mixed
    {
        $items = $this->collectModels($resolved);
        $pieceIds = $items->pluck('piece_id')->unique()->values()->all();
        $pieceCosts = $this->pieceUnitCostsByPieceId($pieceIds);

        return $this->mapResolved($resolved, function (Model $row) use ($pieceCosts) {
            $unit = $pieceCosts[$row->piece_id] ?? null;
            $line = $unit !== null ? round($unit * (float) $row->quantity, 2) : null;
            $row->setAttribute('piece_unit_cost', $unit);
            $row->setAttribute('cost', $line);

            return $row;
        });
    }

    public function appendPieceMaterialCosts(mixed $resolved): mixed
    {
        $bestPrices = $this->bestUnitPricesByMaterialId();

        return $this->mapResolved($resolved, function (Model $row) use ($bestPrices) {
            $unit = $bestPrices[$row->material_id] ?? null;
            $line = $unit !== null ? round($unit * (float) $row->quantity, 2) : null;
            $row->setAttribute('unit_cost', $unit !== null ? round($unit, 2) : null);
            $row->setAttribute('cost', $line);

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
