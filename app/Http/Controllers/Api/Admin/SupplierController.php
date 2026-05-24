<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/suppliers')]
class SupplierController extends Controller
{
    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        $user = auth()->user();

        abort_unless(
            $user->can('suppliers.view')
            || $user->can('material_suppliers.add')
            || $user->can('material_suppliers.edit'),
            403,
            'No tiene permiso para consultar proveedores.',
        );

        return response()->json(Supplier::queryBuilder()->resolve());
    }

    #[Route('GET', '/{supplier}', middleware: 'can:suppliers.view')]
    public function show(Supplier $supplier): JsonResponse
    {
        return response()->json(
            Supplier::queryBuilder()->whereKey($supplier->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:suppliers.add')]
    public function store(SupplierRequest $request): JsonResponse
    {
        $supplier = Supplier::query()->create($request->validated());

        return response()->message('Proveedor creado correctamente.', 201, data: $supplier);
    }

    #[Route('PUT', '/{supplier}', middleware: 'can:suppliers.edit')]
    public function update(SupplierRequest $request, Supplier $supplier): JsonResponse
    {
        $supplier->update($request->validated());

        return response()->message('Proveedor actualizado correctamente.', data: $supplier);
    }

    #[Route('DELETE', '/{supplier}', middleware: 'can:suppliers.delete')]
    public function destroy(Supplier $supplier): JsonResponse
    {
        $supplier->delete();

        return response()->message('Proveedor eliminado correctamente.');
    }
}
