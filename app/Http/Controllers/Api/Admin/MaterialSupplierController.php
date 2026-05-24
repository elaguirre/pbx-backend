<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialSupplierRequest;
use App\Models\MaterialSupplier;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/material-suppliers')]
class MaterialSupplierController extends Controller
{
    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        $user = auth()->user();

        abort_unless(
            $user->can('material_suppliers.view')
            || $user->can('suppliers.view'),
            403,
            'No tiene permiso para consultar materiales de proveedor.',
        );

        return response()->json(MaterialSupplier::queryBuilder()->resolve());
    }

    #[Route('GET', '/{material_supplier}', middleware: 'can:material_suppliers.view')]
    public function show(MaterialSupplier $material_supplier): JsonResponse
    {
        return response()->json(
            MaterialSupplier::queryBuilder()->whereKey($material_supplier->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:material_suppliers.add')]
    public function store(MaterialSupplierRequest $request): JsonResponse
    {
        $materialSupplier = MaterialSupplier::query()->create($request->validated());

        return response()->message('Proveedor asignado al material correctamente.', 201, data: $materialSupplier);
    }

    #[Route('PUT', '/{material_supplier}', middleware: 'can:material_suppliers.edit')]
    public function update(MaterialSupplierRequest $request, MaterialSupplier $material_supplier): JsonResponse
    {
        $material_supplier->update($request->validated());

        return response()->message('Asignación actualizada correctamente.', data: $material_supplier);
    }

    #[Route('DELETE', '/{material_supplier}', middleware: 'can:material_suppliers.delete')]
    public function destroy(MaterialSupplier $material_supplier): JsonResponse
    {
        $material_supplier->delete();

        return response()->message('Proveedor desasignado del material correctamente.');
    }
}
