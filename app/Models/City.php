<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasQueryBuilder;

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'state_id',
    ];

    protected $allowed_sorts = ['id', 'name', 'state_id'];
    protected $default_sorts = ['name'];
    protected $allowed_includes = ['state'];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where('cities.name', 'like', "%{$text}%");
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('state_id')) {
            $query->where('cities.state_id', request('state_id'));
        }

        return $query;
    }
}
