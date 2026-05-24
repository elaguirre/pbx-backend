<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PieceMaterialRequest;
use App\Models\PieceMaterial;
use App\Services\CatalogCostCalculator;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/piece-materials')]
class PieceMaterialController extends Controller
{
    public function __construct(protected CatalogCostCalculator $catalogCosts) {}

    #[Route('GET', '/', middleware: 'can:piece_materials.view')]
    public function index(): JsonResponse
    {
        $resolved = PieceMaterial::queryBuilder()->resolve();

        return response()->json($this->catalogCosts->appendPieceMaterialCosts($resolved));
    }

    #[Route('GET', '/{piece_material}', middleware: 'can:piece_materials.view')]
    public function show(PieceMaterial $piece_material): JsonResponse
    {
        return response()->json(
            PieceMaterial::queryBuilder()->whereKey($piece_material->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:piece_materials.add')]
    public function store(PieceMaterialRequest $request): JsonResponse
    {
        $pieceMaterial = PieceMaterial::query()->create($request->validated());

        return response()->message('Material asignado a la pieza correctamente.', 201, data: $pieceMaterial);
    }

    #[Route('PUT', '/{piece_material}', middleware: 'can:piece_materials.edit')]
    public function update(PieceMaterialRequest $request, PieceMaterial $piece_material): JsonResponse
    {
        $piece_material->update($request->validated());

        return response()->message('Asignación actualizada correctamente.', data: $piece_material);
    }

    #[Route('DELETE', '/{piece_material}', middleware: 'can:piece_materials.delete')]
    public function destroy(PieceMaterial $piece_material): JsonResponse
    {
        $piece_material->delete();

        return response()->message('Material desasignado de la pieza correctamente.');
    }
}
