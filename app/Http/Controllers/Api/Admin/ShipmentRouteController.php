<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShipmentRouteRequest;
use App\Models\ShipmentRoute;
use App\Services\ShipmentRouteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/shipment-routes')]
class ShipmentRouteController extends Controller
{
    public function __construct(protected ShipmentRouteService $shipmentRouteService) {}

    #[Route('GET', '/', middleware: 'can:shipment_routes.view')]
    public function index(): JsonResponse
    {
        if (request()->filled('shipment_id')) {
            $this->shipmentRouteService->syncForShipment((int) request('shipment_id'));
        }

        $resolved = ShipmentRoute::queryBuilder()->resolve();

        $this->shipmentRouteService->attachStatuses($this->extractRouteCollection($resolved));

        return response()->json($resolved);
    }

    #[Route('GET', '/{shipment_route}', middleware: 'can:shipment_routes.view')]
    public function show(ShipmentRoute $shipment_route): JsonResponse
    {
        $route = ShipmentRoute::queryBuilder()
            ->whereKey($shipment_route->getKey())
            ->firstOrFail();

        $this->shipmentRouteService->attachStatuses(collect([$route]));

        return response()->json($route);
    }

    #[Route('POST', '/', middleware: 'can:shipment_routes.add')]
    public function store(ShipmentRouteRequest $request): JsonResponse
    {
        $row = ShipmentRoute::query()->create($request->validated());

        $this->shipmentRouteService->attachStatuses(collect([$row]));

        return response()->message('Parada de ruta agregada correctamente.', 201, data: $row);
    }

    #[Route('PUT', '/{shipment_route}', middleware: 'can:shipment_routes.edit')]
    public function update(ShipmentRouteRequest $request, ShipmentRoute $shipment_route): JsonResponse
    {
        $shipment_route->update($request->validated());

        $this->shipmentRouteService->attachStatuses(collect([$shipment_route]));

        return response()->message('Parada de ruta actualizada correctamente.', data: $shipment_route);
    }

    #[Route('DELETE', '/{shipment_route}', middleware: 'can:shipment_routes.delete')]
    public function destroy(ShipmentRoute $shipment_route): JsonResponse
    {
        $shipment_route->delete();

        return response()->message('Parada de ruta eliminada correctamente.');
    }

    #[Route('POST', '/{shipment_route}/move-up', middleware: 'can:shipment_routes.edit')]
    public function moveUp(ShipmentRoute $shipment_route): JsonResponse
    {
        $this->shipmentRouteService->moveUp($shipment_route);

        $route = ShipmentRoute::queryBuilder()
            ->whereKey($shipment_route->getKey())
            ->firstOrFail();

        $this->shipmentRouteService->attachStatuses(collect([$route]));

        return response()->message('Orden de ruta actualizado.', data: $route);
    }

    #[Route('POST', '/{shipment_route}/move-down', middleware: 'can:shipment_routes.edit')]
    public function moveDown(ShipmentRoute $shipment_route): JsonResponse
    {
        $this->shipmentRouteService->moveDown($shipment_route);

        $route = ShipmentRoute::queryBuilder()
            ->whereKey($shipment_route->getKey())
            ->firstOrFail();

        $this->shipmentRouteService->attachStatuses(collect([$route]));

        return response()->message('Orden de ruta actualizado.', data: $route);
    }

    protected function extractRouteCollection(mixed $resolved): Collection
    {
        if ($resolved instanceof LengthAwarePaginator) {
            return $resolved->getCollection();
        }

        if ($resolved instanceof Collection) {
            return $resolved;
        }

        return collect($resolved);
    }
}
