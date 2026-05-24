<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductionOrderRequest;
use App\Models\ProductionOrder;
use App\Services\ManufacturerLaborCostCalculator;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/production-orders')]
class ProductionOrderController extends Controller
{
    public function __construct(protected ManufacturerLaborCostCalculator $laborCosts) {}

    #[Route('GET', '/', middleware: 'can:production_orders.view')]
    public function index(): JsonResponse
    {
        $resolved = ProductionOrder::queryBuilder()->resolve();

        return response()->json($this->appendProductionOrderListMetrics($resolved));
    }

    #[Route('GET', '/{production_order}', middleware: 'can:production_orders.view')]
    public function show(ProductionOrder $production_order): JsonResponse
    {
        $order = ProductionOrder::queryBuilder()->whereKey($production_order->getKey())->firstOrFail();

        return response()->json($this->appendProductionOrderListMetrics($order));
    }

    private function appendProductionOrderListMetrics(mixed $resolved): mixed
    {
        $resolved = $this->laborCosts->appendProductionOrderLaborCosts($resolved);

        return $this->laborCosts->appendProductionOrderCompletionProgress($resolved);
    }

    #[Route('POST', '/', middleware: 'can:production_orders.add')]
    public function store(ProductionOrderRequest $request): JsonResponse
    {
        $productionOrder = ProductionOrder::query()->create($request->validated());

        return response()->message('Orden de producción creada correctamente.', 201, data: $productionOrder);
    }

    #[Route('PUT', '/{production_order}', middleware: 'can:production_orders.edit')]
    public function update(ProductionOrderRequest $request, ProductionOrder $production_order): JsonResponse
    {
        $production_order->update($request->validated());

        return response()->message('Orden de producción actualizada correctamente.', data: $production_order);
    }

    #[Route('DELETE', '/{production_order}', middleware: 'can:production_orders.delete')]
    public function destroy(ProductionOrder $production_order): JsonResponse
    {
        $production_order->delete();

        return response()->message('Orden de producción eliminada correctamente.');
    }
}
