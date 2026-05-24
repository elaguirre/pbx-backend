<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderPiece;
use App\Models\OrderPieceStatus;

class OrderCheckoutService
{
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
