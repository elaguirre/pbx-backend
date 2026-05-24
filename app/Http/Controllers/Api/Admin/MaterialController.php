<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialRequest;
use App\Models\Material;
use App\Services\CatalogCostCalculator;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/materials')]
class MaterialController extends Controller
{
    public function __construct(protected CatalogCostCalculator $catalogCosts) {}

    #[Route('GET', '/', middleware: 'can:materials.view')]
    public function index(): JsonResponse
    {
        $resolved = Material::queryBuilder()->resolve();

        return response()->json($this->catalogCosts->appendMaterialCosts($resolved));
    }

    #[Route('GET', '/{material}', middleware: 'can:materials.view')]
    public function show(Material $material): JsonResponse
    {
        $item = Material::queryBuilder()->whereKey($material->getKey())->firstOrFail();

        return response()->json($this->catalogCosts->appendMaterialCosts($item));
    }

    #[Route('POST', '/', middleware: 'can:materials.add')]
    public function store(MaterialRequest $request): JsonResponse
    {
        $material = Material::query()->create($request->validated());

        return response()->message('Material creado correctamente.', 201, data: $material);
    }

    #[Route('PUT', '/{material}', middleware: 'can:materials.edit')]
    public function update(MaterialRequest $request, Material $material): JsonResponse
    {
        $material->update($request->validated());

        return response()->message('Material actualizado correctamente.', data: $material);
    }

    #[Route('DELETE', '/{material}', middleware: 'can:materials.delete')]
    public function destroy(Material $material): JsonResponse
    {
        $material->delete();

        return response()->message('Material eliminado correctamente.');
    }
}
