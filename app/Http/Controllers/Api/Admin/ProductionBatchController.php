<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductionBatchRequest;
use App\Models\ProductionBatch;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/production-batches')]
class ProductionBatchController extends Controller
{
    #[Route('GET', '/', middleware: 'can:production_batches.view')]
    public function index(): JsonResponse
    {
        return response()->json(ProductionBatch::queryBuilder()->resolve());
    }

    #[Route('GET', '/{production_batch}', middleware: 'can:production_batches.view')]
    public function show(ProductionBatch $production_batch): JsonResponse
    {
        return response()->json(
            ProductionBatch::queryBuilder()->whereKey($production_batch->getKey())->firstOrFail(),
        );
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
