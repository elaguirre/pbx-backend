<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manufacturer extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'created_at'];
    protected $allowed_includes = ['entity', 'productionOrders', 'manufacturerPieceCosts', 'manufacturerPieceCosts.piece'];

    protected $fillable = [
        'entity_id',
    ];

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function productionOrders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class);
    }

    public function manufacturerPieceCosts(): HasMany
    {
        return $this->hasMany(ManufacturerPieceCost::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('manufacturers.id', $text);
            }

            $query->orWhereHas('entity', function ($query) use ($text) {
                $query->where('entities.name', 'like', "%{$text}%")
                    ->orWhere('entities.rfc', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        return $query;
    }
}
