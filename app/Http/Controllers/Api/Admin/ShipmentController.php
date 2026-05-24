<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShipmentRequest;
use App\Models\Shipment;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/shipments')]
class ShipmentController extends Controller
{
    #[Route('GET', '/', middleware: 'can:shipments.view')]
    public function index(): JsonResponse
    {
        return response()->json(Shipment::queryBuilder()->resolve());
    }

    #[Route('GET', '/{shipment}', middleware: 'can:shipments.view')]
    public function show(Shipment $shipment): JsonResponse
    {
        return response()->json(
            Shipment::queryBuilder()->whereKey($shipment->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:shipments.add')]
    public function store(ShipmentRequest $request): JsonResponse
    {
        $shipment = Shipment::query()->create($request->validated());

        return response()->message('Embarque creado correctamente.', 201, data: $shipment);
    }

    #[Route('PUT', '/{shipment}', middleware: 'can:shipments.edit')]
    public function update(ShipmentRequest $request, Shipment $shipment): JsonResponse
    {
        $shipment->update($request->validated());

        return response()->message('Embarque actualizado correctamente.', data: $shipment);
    }

    #[Route('DELETE', '/{shipment}', middleware: 'can:shipments.delete')]
    public function destroy(Shipment $shipment): JsonResponse
    {
        $shipment->delete();

        return response()->message('Embarque eliminado correctamente.');
    }
}
