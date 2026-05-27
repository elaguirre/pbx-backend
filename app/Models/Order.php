<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'status', 'created_at'];
    protected $allowed_includes = [
        'client',
        'client.entity',
        'client.entity.images',
        'user',
        'concepts',
        'concepts.product',
        'concepts.product.images',
        'orderPieces',
        'orderPieces.piece',
        'orderPieces.orderConcept',
        'deliveryAddress',
        'deliveryAddress.city',
        'deliveryAddress.city.state',
    ];

    protected $fillable = [
        'client_id',
        'delivery_address_id',
        'user_id',
        'status',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function deliveryAddress(): BelongsTo
    {
        return $this->belongsTo(EntityAddress::class, 'delivery_address_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function concepts(): HasMany
    {
        return $this->hasMany(OrderConcept::class);
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
                $query->where('orders.id', $text);
            }

            $query->orWhereHas('client.entity', function ($query) use ($text) {
                $query->where('entities.name', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('client_id')) {
            $query->where('orders.client_id', request('client_id'));
        }

        return $query;
    }
}
