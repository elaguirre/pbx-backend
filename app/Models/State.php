<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasQueryBuilder;

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    protected $allowed_sorts = ['id', 'name'];
    protected $default_sorts = ['name'];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where('states.name', 'like', "%{$text}%");
    }

    public function scopeAdvancedSearch($query)
    {
        return $query;
    }
}
