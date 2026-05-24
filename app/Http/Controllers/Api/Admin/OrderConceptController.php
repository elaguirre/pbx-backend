<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\OrderStatus;
use App\Exceptions\ControlledException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderConceptRequest;
use App\Models\Order;
use App\Models\OrderConcept;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/order-concepts')]
class OrderConceptController extends Controller
{
    #[Route('GET', '/', middleware: 'can:order_concepts.view')]
    public function index(): JsonResponse
    {
        return response()->json(OrderConcept::queryBuilder()->resolve());
    }

    #[Route('GET', '/{order_concept}', middleware: 'can:order_concepts.view')]
    public function show(OrderConcept $order_concept): JsonResponse
    {
        return response()->json(
            OrderConcept::queryBuilder()->whereKey($order_concept->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:order_concepts.add')]
    public function store(OrderConceptRequest $request): JsonResponse
    {
        $this->assertOrderIsEditable($request->integer('order_id'));

        $concept = OrderConcept::query()->create($this->prepareConceptData($request->validated()));

        return response()->message('Concepto agregado correctamente.', 201, data: $concept);
    }

    #[Route('PUT', '/{order_concept}', middleware: 'can:order_concepts.edit')]
    public function update(OrderConceptRequest $request, OrderConcept $order_concept): JsonResponse
    {
        $this->assertOrderIsEditable($order_concept->order_id);

        $order_concept->update($this->prepareConceptData($request->validated()));

        return response()->message('Concepto actualizado correctamente.', data: $order_concept);
    }

    #[Route('DELETE', '/{order_concept}', middleware: 'can:order_concepts.delete')]
    public function destroy(OrderConcept $order_concept): JsonResponse
    {
        $this->assertOrderIsEditable($order_concept->order_id);

        $order_concept->delete();

        return response()->message('Concepto eliminado correctamente.');
    }

    private function prepareConceptData(array $data): array
    {
        $product = Product::query()->findOrFail($data['product_id']);

        if (! array_key_exists('price', $data) || $data['price'] === null) {
            $data['price'] = $product->price;
        }

        if (abs((float) $data['price'] - (float) $product->price) < 0.0001) {
            $data['price_modification_reason'] = null;
        }

        return $data;
    }

    private function assertOrderIsEditable(int $orderId): void
    {
        $order = Order::query()->findOrFail($orderId);

        if ($order->status !== OrderStatus::Started) {
            throw new ControlledException('Solo se pueden modificar pedidos en estado iniciado.', 422);
        }

        if ($order->user_id !== auth()->id() && ! auth()->user()->can('orders.edit')) {
            throw new ControlledException('No puede modificar este pedido.', 403);
        }
    }
}
