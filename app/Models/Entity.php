<?php

namespace App\Models;

use App\Enums\EntityType;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Entity extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'name', 'rfc', 'type', 'created_at'];
    protected $allowed_includes = ['contactData', 'client', 'addresses', 'addresses.city', 'addresses.city.state'];

    protected $fillable = [
        'image',
        'name',
        'rfc',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'type' => EntityType::class,
        ];
    }

    public function contactData(): HasMany
    {
        return $this->hasMany(ContactData::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(EntityAddress::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('entities.id', $text);
            }

            $query
                ->orWhere('entities.name', 'like', "%{$text}%")
                ->orWhere('entities.rfc', 'like', "%{$text}%");
        });
    }

    public function scopeAdvancedSearch($query)
    {
        return $query;
    }
}
