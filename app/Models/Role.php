<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use App\Models\Traits\HasTimezones;
use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\Database\Concerns\IsRole;

class Role extends Model
{
    use IsRole, HasQueryBuilder, HasTimezones;

    // Query Builder attributes
    protected $default_sorts = ['-priority', 'title'];
    protected $allowed_sorts = ['id', 'name', 'priority', 'title', 'created_at'];
    protected $allowed_includes = ['users'];

    protected $fillable = [
        'name',
        'title',
        'priority',
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
    public function scopeSearch($query, $text = '')
    {
        if (!$text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            return $query
                ->whereId($text)
                ->orWhere('name', 'like', '%' . $text . '%')
                ->orWhere('title', 'like', '%' . $text . '%');
        });
    }

    public function scopeAsList($query)
    {
        return $query->select([
            'id as value',
            'priority',
            'is_selectable',
            'title as label',
        ]);
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
