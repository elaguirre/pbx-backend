<?php

namespace App\Models;

use App\Enums\ManufacturerOrderPieceStatus;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManufacturerOrderPiece extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'quantity', 'status', 'created_at'];
    protected $allowed_includes = [
        'productionOrder',
        'productionOrder.manufacturer',
        'productionOrder.manufacturer.entity',
        'orderPiece',
        'orderPiece.piece',
        'orderPiece.orderConcept',
        'orderPiece.orderConcept.product',
        'orderPiece.order',
        'orderPiece.orderPieceStatus',
        'availableStatus',
        'statusOfCompletedPieces',
        'followUp',
        'followUp.user',
    ];

    protected $fillable = [
        'production_order_id',
        'order_piece_id',
        'quantity',
        'status',
        'available_status_id',
        'status_of_completed_pieces',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'status' => ManufacturerOrderPieceStatus::class,
        ];
    }

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function orderPiece(): BelongsTo
    {
        return $this->belongsTo(OrderPiece::class);
    }

    public function availableStatus(): BelongsTo
    {
        return $this->belongsTo(OrderPieceStatus::class, 'available_status_id');
    }

    public function statusOfCompletedPieces(): BelongsTo
    {
        return $this->belongsTo(OrderPieceStatus::class, 'status_of_completed_pieces');
    }

    public function followUp(): HasMany
    {
        return $this->hasMany(ManufacturingFollowUp::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('manufacturer_order_pieces.id', $text);
            }

            $query->orWhereHas('orderPiece.piece', function ($query) use ($text) {
                $query->where('pieces.name', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('production_order_id')) {
            $query->where('manufacturer_order_pieces.production_order_id', request('production_order_id'));
        }

        if (request()->filled('manufacturer_id')) {
            $query->whereHas('productionOrder', function ($query) {
                $query->where('production_orders.manufacturer_id', request('manufacturer_id'));
            });
        }

        if (request()->filled('order_id')) {
            $query->whereHas('orderPiece', function ($query) {
                $query->where('order_pieces.order_id', request('order_id'));
            });
        }

        if (request()->filled('order_piece_id')) {
            $query->where('manufacturer_order_pieces.order_piece_id', request('order_piece_id'));
        }

        return $query;
    }
}
