<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'date',
        'final_date',
        'workstation',
        'user_id',
        'token',
    ];

    protected $casts = [
        'date' => 'datetime',
        'final_date' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function isActive(): bool
    {
        return $this->final_date >= now();
    }

    public function extendTokenLife($minutes = 90)
    {
        if (!$this->isActive()) {
            return false;
        }

        $this->update([
            'final_date' => now()->addMinutes($minutes)
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('date', '<=', now())->where('final_date', '>=', now());
    }

    public function scopeTokenIs($query, $token = '')
    {
        return $query->whereToken($token);
    }

    public function scopeIsAdminSession($query)
    {
        return $query->whereNotNull('user_id');
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

    /*
    |--------------------------------------------------------------------------
    | BOOT
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();

        static::creating(function (Session $session) {
            $session->fill([
                'date' => $session->date ?? now(),
                'final_date' => $session->final_date ?? now()->addMinutes(90),
                'ip' => request()->ip()
            ]);
        });
    }
}
