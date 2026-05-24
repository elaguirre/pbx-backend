<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarrierUnitRequest;
use App\Models\CarrierUnit;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/carrier-units')]
class CarrierUnitController extends Controller
{
    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        $user = auth()->user();

        abort_unless(
            $user->can('carrier_units.view') || $user->can('carriers.view'),
            403,
            'No tiene permiso para consultar unidades de transporte.',
        );

        return response()->json(CarrierUnit::queryBuilder()->resolve());
    }

    #[Route('GET', '/{carrier_unit}', middleware: 'can:carrier_units.view')]
    public function show(CarrierUnit $carrier_unit): JsonResponse
    {
        return response()->json(
            CarrierUnit::queryBuilder()->whereKey($carrier_unit->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:carrier_units.add')]
    public function store(CarrierUnitRequest $request): JsonResponse
    {
        $unit = CarrierUnit::query()->create($request->validated());

        return response()->message('Unidad de transporte creada correctamente.', 201, data: $unit);
    }

    #[Route('PUT', '/{carrier_unit}', middleware: 'can:carrier_units.edit')]
    public function update(CarrierUnitRequest $request, CarrierUnit $carrier_unit): JsonResponse
    {
        $carrier_unit->update($request->validated());

        return response()->message('Unidad de transporte actualizada correctamente.', data: $carrier_unit);
    }

    #[Route('DELETE', '/{carrier_unit}', middleware: 'can:carrier_units.delete')]
    public function destroy(CarrierUnit $carrier_unit): JsonResponse
    {
        $carrier_unit->delete();

        return response()->message('Unidad de transporte eliminada correctamente.');
    }
}
