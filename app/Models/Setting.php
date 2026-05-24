<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'key',
        'type',
        'value',
        'visible',
        'visible_on_web',
        'editable',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getValueAttribute($value): mixed
    {
        return match ($this->type) {
            'string' => (string)$value,
            'integer' => (int)$value,
            'float' => (float)$value,
            'boolean' => (bool)$value,
            'date' => date('Y-m-d', strtotime($value)),
            'datetime' => date('Y-m-d H:i:s', strtotime($value)),
            'time' => date('H:i:s', strtotime($value)),
            'json' => is_string($value) ? json_decode($value, true) : $value,
            default => $value,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
