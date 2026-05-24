<?php

namespace App\Models;

use App\Enums\EntityAddressType;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityAddress extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'type', 'street', 'created_at'];
    protected $allowed_includes = ['entity', 'city', 'city.state'];

    protected $fillable = [
        'entity_id',
        'type',
        'street',
        'external_number',
        'internal_number',
        'suburb',
        'city_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => EntityAddressType::class,
            'city_id' => 'integer',
        ];
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('entity_addresses.id', $text);
            }

            $query->orWhere('entity_addresses.street', 'like', "%{$text}%")
                ->orWhere('entity_addresses.suburb', 'like', "%{$text}%");
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('entity_id')) {
            $query->where('entity_addresses.entity_id', request('entity_id'));
        }

        return $query;
    }
}
