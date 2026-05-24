<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\OrderStatus;
use App\Exceptions\ControlledException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Requests\Admin\StartOrderRequest;
use App\Models\Order;
use App\Services\OrderCheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/orders')]
class OrderController extends Controller
{
    public function __construct(protected OrderCheckoutService $orderCheckout) {}
    #[Route('GET', '/', middleware: 'can:orders.view')]
    public function index(): JsonResponse
    {
        return response()->json(Order::queryBuilder()->resolve());
    }

    #[Route('GET', '/current', middleware: 'can:orders.view')]
    public function current(): JsonResponse
    {
        $order = Order::queryBuilder()
            ->where('user_id', auth()->id())
            ->where('status', OrderStatus::Started)
            ->first();

        return response()->json($order);
    }

    #[Route('GET', '/{order}', middleware: 'can:orders.view')]
    public function show(Order $order): JsonResponse
    {
        return response()->json(
            Order::queryBuilder()->whereKey($order->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/start', middleware: 'can:orders.add')]
    public function start(StartOrderRequest $request): JsonResponse
    {
        $userId = auth()->id();

        Order::query()
            ->where('user_id', $userId)
            ->where('status', OrderStatus::Started)
            ->delete();

        $order = Order::query()->create([
            'client_id' => $request->validated('client_id'),
            'user_id' => $userId,
            'status' => OrderStatus::Started,
        ]);

        $order = Order::queryBuilder()->whereKey($order->getKey())->firstOrFail();

        return response()->message('Pedido iniciado correctamente.', 201, data: $order);
    }

    #[Route('POST', '/{order}/checkout', middleware: 'can:orders.checkout')]
    public function checkout(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id() && ! auth()->user()->can('orders.edit')) {
            throw new ControlledException('No puede cerrar este pedido.', 403);
        }

        if ($order->status !== OrderStatus::Started) {
            throw new ControlledException('Solo se pueden cerrar pedidos en estado iniciado.', 422);
        }

        if ($order->concepts()->count() === 0) {
            throw new ControlledException('El pedido debe tener al menos un concepto.', 422);
        }

        DB::transaction(function () use ($order) {
            $this->orderCheckout->generateOrderPieces($order);
            $order->update(['status' => OrderStatus::InProgress]);
        });

        $order = Order::queryBuilder()->whereKey($order->getKey())->firstOrFail();

        return response()->message('Pedido cerrado correctamente.', data: $order);
    }

    #[Route('PUT', '/{order}', middleware: 'can:orders.edit')]
    public function update(OrderRequest $request, Order $order): JsonResponse
    {
        $order->update($request->validated());

        return response()->message('Pedido actualizado correctamente.', data: $order);
    }

    #[Route('DELETE', '/{order}', middleware: 'can:orders.delete')]
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->message('Pedido eliminado correctamente.');
    }
}
