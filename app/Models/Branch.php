<?php

namespace App\Models;

use App\Models\Traits\HasActiveColumn;
use App\Models\Traits\HasQueryBuilder;
use App\Models\Traits\HasTimezones;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Branch extends Model
{
    use HasQueryBuilder, HasFactory, HasTimezones, HasActiveColumn;

    // Query Builder attributes
    protected $default_sorts = ['-branches.active', '-branches.id'];
    protected $allowed_sorts = ['branch', 'city_id', 'branches.active'];
    protected $allowed_includes = ['city.state', 'place'];

    protected $fillable = [
        'branch',
        'city_id',
        'address',
        'schedule',
        'url',
        'comments',
        'active',
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
    public function city()
    {
        return $this->belongsTo(City::class);
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
            return $query->where('branch', 'like', '%' . $text . '%');
        });
    }

    public function scopeAdvancedSearch($query)
    {
        return $query
            ->branchIdIs(request('branch_id'));
    }

    public function scopeBranchIdIs($query, $value)
    {
        if (!$value) {
            return $query;
        }

        return $query->where('branches.id', $value);
    }

    public function scopeAsList($query)
    {
        return $query->join('cities', 'cities.id', '=', 'city_id')
            ->join('states', 'states.id', '=', 'cities.state_id')
            ->select([
                'branches.id as value',
                'branches.branch as label',
                DB::raw('IF(branches.active, 0, 1) as disabled'),
                'cities.name as group',
                'states.name as state',
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
