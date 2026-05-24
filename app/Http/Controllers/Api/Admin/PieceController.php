<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PieceRequest;
use App\Models\Piece;
use App\Services\CatalogCostCalculator;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/pieces')]
class PieceController extends Controller
{
    public function __construct(protected CatalogCostCalculator $catalogCosts) {}

    #[Route('GET', '/', middleware: 'can:pieces.view')]
    public function index(): JsonResponse
    {
        $resolved = Piece::queryBuilder()->resolve();

        return response()->json($this->catalogCosts->appendPieceCosts($resolved));
    }

    #[Route('GET', '/{piece}', middleware: 'can:pieces.view')]
    public function show(Piece $piece): JsonResponse
    {
        $item = Piece::queryBuilder()->whereKey($piece->getKey())->firstOrFail();

        return response()->json($this->catalogCosts->appendPieceCosts($item));
    }

    #[Route('POST', '/', middleware: 'can:pieces.add')]
    public function store(PieceRequest $request): JsonResponse
    {
        $piece = Piece::query()->create($request->validated());

        return response()->message('Pieza creada correctamente.', 201, data: $piece);
    }

    #[Route('PUT', '/{piece}', middleware: 'can:pieces.edit')]
    public function update(PieceRequest $request, Piece $piece): JsonResponse
    {
        $piece->update($request->validated());

        return response()->message('Pieza actualizada correctamente.', data: $piece);
    }

    #[Route('DELETE', '/{piece}', middleware: 'can:pieces.delete')]
    public function destroy(Piece $piece): JsonResponse
    {
        $piece->delete();

        return response()->message('Pieza eliminada correctamente.');
    }
}
