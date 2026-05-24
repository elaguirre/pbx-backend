<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentRoute extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['order'];
    protected $allowed_sorts = ['id', 'order', 'created_at'];
    protected $allowed_includes = [
        'shipment',
        'entityAddress',
        'entityAddress.entity',
        'entityAddress.city',
        'entityAddress.city.state',
    ];

    protected $fillable = [
        'shipment_id',
        'entity_address_id',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function entityAddress(): BelongsTo
    {
        return $this->belongsTo(EntityAddress::class, 'entity_address_id');
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('shipment_routes.id', $text);
            }

            $query->orWhereHas('entityAddress', function ($query) use ($text) {
                $query->where('entity_addresses.street', 'like', "%{$text}%")
                    ->orWhere('entity_addresses.suburb', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('shipment_id')) {
            $query->where('shipment_routes.shipment_id', request('shipment_id'));
        }

        return $query;
    }
}
