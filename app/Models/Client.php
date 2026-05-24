<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'term_in_days', 'created_at'];
    protected $allowed_includes = ['entity', 'entity.contactData'];

    protected $fillable = [
        'entity_id',
        'term_in_days',
    ];

    protected function casts(): array
    {
        return [
            'term_in_days' => 'integer',
        ];
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('clients.id', $text);
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
