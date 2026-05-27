<?php

namespace App\Services;

use App\Exceptions\ControlledException;
use App\Models\Order;
use App\Models\OrderPiece;
use App\Models\OrderPieceStatus;

class OrderCheckoutService
{
    public function assertAllConceptProductsHavePieces(Order $order): void
    {
        $order->load([
            'concepts.product' => fn ($query) => $query->withCount(['productPieces as pieces']),
        ]);

        $productNames = $order->concepts
            ->filter(fn ($concept) => $concept->product && (int) $concept->product->pieces < 1)
            ->map(fn ($concept) => $concept->product->name)
            ->unique()
            ->values()
            ->all();

        if ($productNames !== []) {
            throw new ControlledException(
                'No se puede cerrar el pedido. Los siguientes productos no tienen piezas en catálogo: '
                .implode(', ', $productNames)
                .'.',
                422,
            );
        }
    }

    public function generateOrderPieces(Order $order): void
    {
        $order->load(['concepts.product.productPieces']);

        $rows = [];
        $now = now();
        $initialStatusId = OrderPieceStatus::initialId();

        foreach ($order->concepts as $concept) {
            foreach ($concept->product->productPieces as $productPiece) {
                $rows[] = [
                    'order_id' => $order->id,
                    'order_concept_id' => $concept->id,
                    'piece_id' => $productPiece->piece_id,
                    'quantity' => $productPiece->quantity * $concept->quantity,
                    'order_piece_status_id' => $initialStatusId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if ($rows !== []) {
            OrderPiece::query()->insert($rows);
        }
    }
}
