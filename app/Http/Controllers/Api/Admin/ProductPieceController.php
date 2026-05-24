<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductPieceRequest;
use App\Models\ProductPiece;
use App\Services\CatalogCostCalculator;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/product-pieces')]
class ProductPieceController extends Controller
{
    public function __construct(protected CatalogCostCalculator $catalogCosts) {}

    #[Route('GET', '/', middleware: 'can:product_pieces.view')]
    public function index(): JsonResponse
    {
        $resolved = ProductPiece::queryBuilder()->resolve();

        return response()->json($this->catalogCosts->appendProductPieceCosts($resolved));
    }

    #[Route('GET', '/{product_piece}', middleware: 'can:product_pieces.view')]
    public function show(ProductPiece $product_piece): JsonResponse
    {
        return response()->json(
            ProductPiece::queryBuilder()->whereKey($product_piece->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:product_pieces.add')]
    public function store(ProductPieceRequest $request): JsonResponse
    {
        $productPiece = ProductPiece::query()->create($request->validated());

        return response()->message('Pieza asignada al producto correctamente.', 201, data: $productPiece);
    }

    #[Route('PUT', '/{product_piece}', middleware: 'can:product_pieces.edit')]
    public function update(ProductPieceRequest $request, ProductPiece $product_piece): JsonResponse
    {
        $product_piece->update($request->validated());

        return response()->message('Asignación actualizada correctamente.', data: $product_piece);
    }

    #[Route('DELETE', '/{product_piece}', middleware: 'can:product_pieces.delete')]
    public function destroy(ProductPiece $product_piece): JsonResponse
    {
        $product_piece->delete();

        return response()->message('Pieza desasignada del producto correctamente.');
    }
}
