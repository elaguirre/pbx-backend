<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductionBatchRequest;
use App\Models\ProductionBatch;
use App\Services\ManufacturerLaborCostCalculator;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/production-batches')]
class ProductionBatchController extends Controller
{
    public function __construct(protected ManufacturerLaborCostCalculator $laborCosts) {}

    #[Route('GET', '/', middleware: 'can:production_batches.view')]
    public function index(): JsonResponse
    {
        $resolved = ProductionBatch::queryBuilder()->resolve();

        return response()->json($this->appendProductionBatchListMetrics($resolved));
    }

    #[Route('GET', '/{production_batch}', middleware: 'can:production_batches.view')]
    public function show(ProductionBatch $production_batch): JsonResponse
    {
        $batch = ProductionBatch::queryBuilder()->whereKey($production_batch->getKey())->firstOrFail();

        return response()->json($this->appendProductionBatchListMetrics($batch));
    }

    private function appendProductionBatchListMetrics(mixed $resolved): mixed
    {
        return $this->laborCosts->appendProductionBatchCompletionProgress($resolved);
    }

    #[Route('POST', '/', middleware: 'can:production_batches.add')]
    public function store(ProductionBatchRequest $request): JsonResponse
    {
        $productionBatch = ProductionBatch::query()->create();

        return response()->message('Lote de producción creado correctamente.', 201, data: $productionBatch);
    }

    #[Route('PUT', '/{production_batch}', middleware: 'can:production_batches.edit')]
    public function update(ProductionBatchRequest $request, ProductionBatch $production_batch): JsonResponse
    {
        return response()->message('Lote de producción actualizado correctamente.', data: $production_batch);
    }

    #[Route('DELETE', '/{production_batch}', middleware: 'can:production_batches.delete')]
    public function destroy(ProductionBatch $production_batch): JsonResponse
    {
        $production_batch->delete();

        return response()->message('Lote de producción eliminado correctamente.');
    }
}
