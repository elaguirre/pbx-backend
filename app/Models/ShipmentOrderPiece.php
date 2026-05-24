<?php

namespace App\Models;

use App\Enums\ShipmentOrderPieceStatus;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentOrderPiece extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'quantity', 'created_at'];
    protected $allowed_includes = [
        'shipment',
        'orderPiece',
        'orderPiece.piece',
        'orderPiece.orderConcept',
        'orderPiece.orderConcept.product',
        'orderPiece.order',
    ];

    protected $fillable = [
        'shipment_id',
        'order_piece_id',
        'quantity',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'status' => ShipmentOrderPieceStatus::class,
        ];
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function orderPiece(): BelongsTo
    {
        return $this->belongsTo(OrderPiece::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('shipment_order_pieces.id', $text);
            }
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('shipment_id')) {
            $query->where('shipment_order_pieces.shipment_id', request('shipment_id'));
        }

        return $query;
    }
}
