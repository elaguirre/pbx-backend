<?php

namespace App\Models;

use App\Models\Traits\HasActiveColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrustedDevice extends Model
{
    use HasFactory, SoftDeletes, HasActiveColumn;

    protected $fillable = [
        'fingerprint',
        'valid_until',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
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

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeIsValid($query)
    {
        return $query->active()->where('valid_until', '>=', now());
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
