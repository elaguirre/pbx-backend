<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialSupplierPriceRequest;
use App\Models\MaterialSupplierPrice;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/material-supplier-prices')]
class MaterialSupplierPriceController extends Controller
{
    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        $user = auth()->user();

        abort_unless(
            $user->can('material_supplier_prices.view')
            || $user->can('material_suppliers.view'),
            403,
            'No tiene permiso para consultar precios de proveedor.',
        );

        return response()->json(MaterialSupplierPrice::queryBuilder()->resolve());
    }

    #[Route('GET', '/{material_supplier_price}', middleware: 'can:material_supplier_prices.view')]
    public function show(MaterialSupplierPrice $material_supplier_price): JsonResponse
    {
        return response()->json(
            MaterialSupplierPrice::queryBuilder()->whereKey($material_supplier_price->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:material_supplier_prices.add')]
    public function store(MaterialSupplierPriceRequest $request): JsonResponse
    {
        $price = MaterialSupplierPrice::query()->create($request->validated());

        return response()->message('Precio registrado correctamente.', 201, data: $price);
    }

    #[Route('PUT', '/{material_supplier_price}', middleware: 'can:material_supplier_prices.edit')]
    public function update(MaterialSupplierPriceRequest $request, MaterialSupplierPrice $material_supplier_price): JsonResponse
    {
        $material_supplier_price->update($request->validated());

        return response()->message('Precio actualizado correctamente.', data: $material_supplier_price);
    }

    #[Route('DELETE', '/{material_supplier_price}', middleware: 'can:material_supplier_prices.delete')]
    public function destroy(MaterialSupplierPrice $material_supplier_price): JsonResponse
    {
        $material_supplier_price->delete();

        return response()->message('Precio eliminado correctamente.');
    }
}
