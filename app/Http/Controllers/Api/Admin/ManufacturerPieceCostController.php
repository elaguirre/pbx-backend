<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManufacturerPieceCostRequest;
use App\Models\ManufacturerPieceCost;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/manufacturer-pieces-cost')]
class ManufacturerPieceCostController extends Controller
{
    #[Route('GET', '/', middleware: 'can:manufacturer_pieces_cost.view')]
    public function index(): JsonResponse
    {
        return response()->json(ManufacturerPieceCost::queryBuilder()->resolve());
    }

    #[Route('GET', '/{manufacturer_piece_cost}', middleware: 'can:manufacturer_pieces_cost.view')]
    public function show(ManufacturerPieceCost $manufacturer_piece_cost): JsonResponse
    {
        return response()->json(
            ManufacturerPieceCost::queryBuilder()->whereKey($manufacturer_piece_cost->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:manufacturer_pieces_cost.add')]
    public function store(ManufacturerPieceCostRequest $request): JsonResponse
    {
        $cost = ManufacturerPieceCost::query()->create($request->validated());

        return response()->message('Costo de pieza registrado correctamente.', 201, data: $cost);
    }

    #[Route('PUT', '/{manufacturer_piece_cost}', middleware: 'can:manufacturer_pieces_cost.edit')]
    public function update(ManufacturerPieceCostRequest $request, ManufacturerPieceCost $manufacturer_piece_cost): JsonResponse
    {
        $manufacturer_piece_cost->update($request->validated());

        return response()->message('Costo de pieza actualizado correctamente.', data: $manufacturer_piece_cost);
    }

    #[Route('DELETE', '/{manufacturer_piece_cost}', middleware: 'can:manufacturer_pieces_cost.delete')]
    public function destroy(ManufacturerPieceCost $manufacturer_piece_cost): JsonResponse
    {
        $manufacturer_piece_cost->delete();

        return response()->message('Costo de pieza eliminado correctamente.');
    }
}
