<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'created_at'];
    protected $allowed_includes = ['entity', 'carrier', 'carrier.entity'];

    protected $fillable = [
        'carrier_id',
        'entity_id',
    ];

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function shipmentDrivers(): HasMany
    {
        return $this->hasMany(ShipmentDriver::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('drivers.id', $text);
            }

            $query->orWhereHas('entity', function ($query) use ($text) {
                $query->where('entities.name', 'like', "%{$text}%")
                    ->orWhere('entities.rfc', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('carrier_id')) {
            $query->where('drivers.carrier_id', request('carrier_id'));
        }

        return $query;
    }
}
