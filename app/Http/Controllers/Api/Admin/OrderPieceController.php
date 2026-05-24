<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderPieceRequest;
use App\Models\OrderPiece;
use App\Services\OrderPieceAssignmentCalculator;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/order-pieces')]
class OrderPieceController extends Controller
{
    public function __construct(protected OrderPieceAssignmentCalculator $assignmentTotals) {}

    #[Route('GET', '/', middleware: 'can:order_pieces.view')]
    public function index(): JsonResponse
    {
        $resolved = OrderPiece::queryBuilder()->resolve();

        return response()->json($this->appendAssignmentTotals($resolved));
    }

    #[Route('GET', '/{order_piece}', middleware: 'can:order_pieces.view')]
    public function show(OrderPiece $order_piece): JsonResponse
    {
        $orderPiece = OrderPiece::queryBuilder()->whereKey($order_piece->getKey())->firstOrFail();

        return response()->json($this->appendAssignmentTotals($orderPiece));
    }

    private function appendAssignmentTotals(mixed $resolved): mixed
    {
        $productionOrderId = request()->integer('for_production_order_id') ?: null;
        $editingId = request()->integer('editing_manufacturer_order_piece_id') ?: null;

        return $this->assignmentTotals->appendAssignmentTotals($resolved, $productionOrderId, $editingId);
    }

    #[Route('POST', '/', middleware: 'can:order_pieces.add')]
    public function store(OrderPieceRequest $request): JsonResponse
    {
        $orderPiece = OrderPiece::query()->create($request->validated());

        return response()->message('Pieza de pedido registrada correctamente.', 201, data: $orderPiece);
    }

    #[Route('PUT', '/{order_piece}', middleware: 'can:order_pieces.edit')]
    public function update(OrderPieceRequest $request, OrderPiece $order_piece): JsonResponse
    {
        $order_piece->update($request->validated());

        return response()->message('Pieza de pedido actualizada correctamente.', data: $order_piece);
    }

    #[Route('DELETE', '/{order_piece}', middleware: 'can:order_pieces.delete')]
    public function destroy(OrderPiece $order_piece): JsonResponse
    {
        $order_piece->delete();

        return response()->message('Pieza de pedido eliminada correctamente.');
    }
}
