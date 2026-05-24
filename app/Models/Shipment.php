<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'created_at'];
    protected $allowed_includes = [
        'carrier',
        'carrier.entity',
        'carrierUnit',
        'driver',
        'driver.entity',
        'orderPieces',
        'orderPieces.orderPiece',
        'orderPieces.orderPiece.piece',
        'orderPieces.orderPiece.order',
        'shipmentDrivers',
        'shipmentDrivers.driver',
        'shipmentDrivers.driver.entity',
        'routes',
        'routes.entityAddress',
        'routes.entityAddress.entity',
        'routes.entityAddress.city',
        'routes.entityAddress.city.state',
    ];

    protected $fillable = [
        'carrier_id',
        'carrier_unit_id',
        'driver_id',
    ];

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function carrierUnit(): BelongsTo
    {
        return $this->belongsTo(CarrierUnit::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function orderPieces(): HasMany
    {
        return $this->hasMany(ShipmentOrderPiece::class);
    }

    public function shipmentDrivers(): HasMany
    {
        return $this->hasMany(ShipmentDriver::class);
    }

    public function routes(): HasMany
    {
        return $this->hasMany(ShipmentRoute::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('shipments.id', $text);
            }

            $query->orWhereHas('carrier.entity', function ($query) use ($text) {
                $query->where('entities.name', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('carrier_id')) {
            $query->where('shipments.carrier_id', request('carrier_id'));
        }

        return $query;
    }
}
