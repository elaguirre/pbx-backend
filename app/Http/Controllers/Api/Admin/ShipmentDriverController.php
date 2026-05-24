<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShipmentDriverRequest;
use App\Models\ShipmentDriver;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/shipment-drivers')]
class ShipmentDriverController extends Controller
{
    #[Route('GET', '/', middleware: 'can:shipment_drivers.view')]
    public function index(): JsonResponse
    {
        return response()->json(ShipmentDriver::queryBuilder()->resolve());
    }

    #[Route('GET', '/{shipment_driver}', middleware: 'can:shipment_drivers.view')]
    public function show(ShipmentDriver $shipment_driver): JsonResponse
    {
        return response()->json(
            ShipmentDriver::queryBuilder()->whereKey($shipment_driver->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:shipment_drivers.add')]
    public function store(ShipmentDriverRequest $request): JsonResponse
    {
        $row = ShipmentDriver::query()->create($request->validated());

        return response()->message('Conductor asignado al embarque correctamente.', 201, data: $row);
    }

    #[Route('PUT', '/{shipment_driver}', middleware: 'can:shipment_drivers.edit')]
    public function update(ShipmentDriverRequest $request, ShipmentDriver $shipment_driver): JsonResponse
    {
        $shipment_driver->update($request->validated());

        return response()->message('Asignación de conductor actualizada correctamente.', data: $shipment_driver);
    }

    #[Route('DELETE', '/{shipment_driver}', middleware: 'can:shipment_drivers.delete')]
    public function destroy(ShipmentDriver $shipment_driver): JsonResponse
    {
        $shipment_driver->delete();

        return response()->message('Conductor quitado del embarque correctamente.');
    }
}
