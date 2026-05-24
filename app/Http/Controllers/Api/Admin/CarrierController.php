<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarrierRequest;
use App\Models\Carrier;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/carriers')]
class CarrierController extends Controller
{
    #[Route('GET', '/', middleware: 'can:carriers.view')]
    public function index(): JsonResponse
    {
        return response()->json(Carrier::queryBuilder()->resolve());
    }

    #[Route('GET', '/{carrier}', middleware: 'can:carriers.view')]
    public function show(Carrier $carrier): JsonResponse
    {
        return response()->json(
            Carrier::queryBuilder()->whereKey($carrier->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:carriers.add')]
    public function store(CarrierRequest $request): JsonResponse
    {
        $carrier = Carrier::query()->create($request->validated());

        return response()->message('Transportista creado correctamente.', 201, data: $carrier);
    }

    #[Route('PUT', '/{carrier}', middleware: 'can:carriers.edit')]
    public function update(CarrierRequest $request, Carrier $carrier): JsonResponse
    {
        $carrier->update($request->validated());

        return response()->message('Transportista actualizado correctamente.', data: $carrier);
    }

    #[Route('DELETE', '/{carrier}', middleware: 'can:carriers.delete')]
    public function destroy(Carrier $carrier): JsonResponse
    {
        $carrier->delete();

        return response()->message('Transportista eliminado correctamente.');
    }
}
