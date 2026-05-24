<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManufacturerRequest;
use App\Models\Manufacturer;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/manufacturers')]
class ManufacturerController extends Controller
{
    #[Route('GET', '/', middleware: 'can:manufacturers.view')]
    public function index(): JsonResponse
    {
        return response()->json(Manufacturer::queryBuilder()->resolve());
    }

    #[Route('GET', '/{manufacturer}', middleware: 'can:manufacturers.view')]
    public function show(Manufacturer $manufacturer): JsonResponse
    {
        return response()->json(
            Manufacturer::queryBuilder()->whereKey($manufacturer->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:manufacturers.add')]
    public function store(ManufacturerRequest $request): JsonResponse
    {
        $manufacturer = Manufacturer::query()->create($request->validated());

        return response()->message('Maquilador creado correctamente.', 201, data: $manufacturer);
    }

    #[Route('PUT', '/{manufacturer}', middleware: 'can:manufacturers.edit')]
    public function update(ManufacturerRequest $request, Manufacturer $manufacturer): JsonResponse
    {
        $manufacturer->update($request->validated());

        return response()->message('Maquilador actualizado correctamente.', data: $manufacturer);
    }

    #[Route('DELETE', '/{manufacturer}', middleware: 'can:manufacturers.delete')]
    public function destroy(Manufacturer $manufacturer): JsonResponse
    {
        $manufacturer->delete();

        return response()->message('Maquilador eliminado correctamente.');
    }
}
