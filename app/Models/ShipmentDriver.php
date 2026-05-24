<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentDriver extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'created_at'];
    protected $allowed_includes = [
        'shipment',
        'driver',
        'driver.entity',
    ];

    protected $fillable = [
        'shipment_id',
        'driver_id',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('shipment_drivers.id', $text);
            }
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('shipment_id')) {
            $query->where('shipment_drivers.shipment_id', request('shipment_id'));
        }

        return $query;
    }
}
