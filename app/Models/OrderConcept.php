<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderConcept extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'quantity', 'price', 'created_at'];
    protected $allowed_includes = ['order', 'product', 'orderPieces', 'orderPieces.piece'];

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'price_modification_reason',
        'details',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderPieces(): HasMany
    {
        return $this->hasMany(OrderPiece::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('order_concepts.id', $text);
            }

            $query->orWhereHas('product', function ($query) use ($text) {
                $query->where('products.name', 'like', "%{$text}%")
                    ->orWhere('products.sku', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('order_id')) {
            $query->where('order_concepts.order_id', request('order_id'));
        }

        return $query;
    }
}
