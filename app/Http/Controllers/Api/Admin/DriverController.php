<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DriverRequest;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/drivers')]
class DriverController extends Controller
{
    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        $user = auth()->user();

        abort_unless(
            $user->can('drivers.view')
            || $user->can('carriers.view')
            || $user->can('shipments.add')
            || $user->can('shipments.edit')
            || $user->can('shipment_drivers.add'),
            403,
            'No tiene permiso para consultar conductores.',
        );

        return response()->json(Driver::queryBuilder()->resolve());
    }

    #[Route('GET', '/{driver}', middleware: 'can:drivers.view')]
    public function show(Driver $driver): JsonResponse
    {
        return response()->json(
            Driver::queryBuilder()->whereKey($driver->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:drivers.add')]
    public function store(DriverRequest $request): JsonResponse
    {
        $driver = Driver::query()->create($request->validated());

        return response()->message('Conductor creado correctamente.', 201, data: $driver);
    }

    #[Route('PUT', '/{driver}', middleware: 'can:drivers.edit')]
    public function update(DriverRequest $request, Driver $driver): JsonResponse
    {
        $driver->update($request->validated());

        return response()->message('Conductor actualizado correctamente.', data: $driver);
    }

    #[Route('DELETE', '/{driver}', middleware: 'can:drivers.delete')]
    public function destroy(Driver $driver): JsonResponse
    {
        $driver->delete();

        return response()->message('Conductor eliminado correctamente.');
    }
}
