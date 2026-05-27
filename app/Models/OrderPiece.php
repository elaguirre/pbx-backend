<?php

namespace App\Models;

use App\Enums\ManufacturerOrderPieceStatus;
use App\Enums\OrderPieceStatusRole;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderPiece extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'quantity', 'created_at'];
    protected $allowed_includes = [
        'order',
        'order.client',
        'order.client.entity',
        'orderConcept',
        'orderConcept.product',
        'piece',
        'orderPieceStatus',
        'manufacturerOrderPieces',
    ];

    protected $fillable = [
        'order_id',
        'order_concept_id',
        'piece_id',
        'quantity',
        'order_piece_status_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderConcept(): BelongsTo
    {
        return $this->belongsTo(OrderConcept::class);
    }

    public function piece(): BelongsTo
    {
        return $this->belongsTo(Piece::class);
    }

    public function orderPieceStatus(): BelongsTo
    {
        return $this->belongsTo(OrderPieceStatus::class);
    }

    public function manufacturerOrderPieces(): HasMany
    {
        return $this->hasMany(ManufacturerOrderPiece::class);
    }

    public function shipmentOrderPieces(): HasMany
    {
        return $this->hasMany(ShipmentOrderPiece::class);
    }

    public function shippedQuantity(?int $excludeShipmentOrderPieceId = null): float
    {
        return (float) $this->shipmentOrderPieces()
            ->when(
                $excludeShipmentOrderPieceId,
                fn ($query) => $query->whereKeyNot($excludeShipmentOrderPieceId),
            )
            ->sum('quantity');
    }

    public function remainingShippableQuantity(?int $excludeShipmentOrderPieceId = null): float
    {
        return max(0, (float) $this->quantity - $this->shippedQuantity($excludeShipmentOrderPieceId));
    }

    /**
     * Pieza lista para embarque: tiene manufactura completada cuyo estado al liberar tiene rol SHIPPABLE.
     */
    public function scopeShippableForShipment($query)
    {
        return $query->whereHas('manufacturerOrderPieces', function ($query) {
            $query
                ->where('status', ManufacturerOrderPieceStatus::Completed)
                ->whereHas('statusOfCompletedPieces', function ($query) {
                    $query->where('role', OrderPieceStatusRole::Shippable);
                });
        });
    }

    public static function isShippableForShipment(int $orderPieceId): bool
    {
        return static::query()
            ->whereKey($orderPieceId)
            ->shippableForShipment()
            ->exists();
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('order_pieces.id', $text);
            }

            $query->orWhereHas('piece', function ($query) use ($text) {
                $query->where('pieces.name', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('order_id')) {
            $query->where('order_pieces.order_id', request('order_id'));
        }

        if (request()->filled('order_concept_id')) {
            $query->where('order_pieces.order_concept_id', request('order_concept_id'));
        }

        if (request()->filled('piece_id')) {
            $query->where('order_pieces.piece_id', request('piece_id'));
        }

        if (request()->filled('available_status_id')) {
            $query->where('order_pieces.order_piece_status_id', request('available_status_id'));
        }

        if (request()->filled('order_piece_status_id')) {
            $query->where('order_pieces.order_piece_status_id', request('order_piece_status_id'));
        }

        if (request()->boolean('include_shipped_quantity')) {
            $query->withSum('shipmentOrderPieces as shipped_quantity', 'quantity');
        }

        if (request()->boolean('shippable_for_shipment')) {
            $query
                ->shippableForShipment()
                ->withSum('shipmentOrderPieces as shipped_quantity', 'quantity')
                ->whereRaw(
                    'order_pieces.quantity > COALESCE((
                        SELECT SUM(sop.quantity)
                        FROM shipment_order_pieces sop
                        WHERE sop.order_piece_id = order_pieces.id
                    ), 0)',
                );
        }

        return $query;
    }
}
