<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarrierUnit extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = [
        'id',
        'load_volume_capacity',
        'load_weight_capacity',
        'created_at',
    ];
    protected $allowed_includes = ['carrier', 'carrier.entity'];

    protected $fillable = [
        'carrier_id',
        'description',
        'load_volume_capacity',
        'load_weight_capacity',
    ];

    protected function casts(): array
    {
        return [
            'load_volume_capacity' => 'decimal:4',
            'load_weight_capacity' => 'decimal:4',
        ];
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('carrier_units.id', $text);
            }

            $query->orWhere('carrier_units.description', 'like', "%{$text}%");
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('carrier_id')) {
            $query->where('carrier_units.carrier_id', request('carrier_id'));
        }

        return $query;
    }
}
