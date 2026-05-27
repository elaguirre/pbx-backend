<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Services\CatalogCostCalculator;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/products')]
class ProductController extends Controller
{
    public function __construct(protected CatalogCostCalculator $catalogCosts) {}

    #[Route('GET', '/', middleware: 'can:products.view')]
    public function index(): JsonResponse
    {
        $resolved = Product::queryBuilder()->resolve();

        return response()->json($this->catalogCosts->appendProductCosts($resolved));
    }

    #[Route('GET', '/{product}', middleware: 'can:products.view')]
    public function show(Product $product): JsonResponse
    {
        $item = Product::queryBuilder()->whereKey($product->getKey())->firstOrFail();

        return response()->json($this->catalogCosts->appendProductCosts($item));
    }

    #[Route('POST', '/', middleware: 'can:products.add')]
    public function store(ProductRequest $request): JsonResponse
    {
        $product = Product::query()->create($request->safe()->except(['image', 'remove_image']));

        if ($request->hasFile('image')) {
            $product->storeMainImage($request->file('image'));
        }

        $product->load('images');

        return response()->message('Producto creado correctamente.', 201, data: $product);
    }

    #[Route('PUT', '/{product}', middleware: 'can:products.edit')]
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->safe()->except(['image', 'remove_image']));

        if ($request->boolean('remove_image')) {
            $product->deleteMainImage();
        }

        if ($request->hasFile('image')) {
            $product->storeMainImage($request->file('image'));
        }

        $product->load('images');

        return response()->message('Producto actualizado correctamente.', data: $product);
    }

    #[Route('DELETE', '/{product}', middleware: 'can:products.delete')]
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->message('Producto eliminado correctamente.');
    }
}
