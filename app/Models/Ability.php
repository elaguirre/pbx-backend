<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use App\Models\Traits\HasTimezones;
use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\Database\Concerns\IsAbility;

class Ability extends Model
{
    use IsAbility, HasTimezones, HasQueryBuilder;

    // Query Builder attributes
    protected $default_sorts = ['group', 'title'];
    protected $allowed_sorts = ['group', 'name', 'title'];

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
    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeSearch($query, $text = '')
    {
        if (!$text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            return $query
                ->whereId($text)
                ->orWhere('title', 'like', '%' . $text . '%');
        });
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
