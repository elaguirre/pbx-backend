<?php

namespace App\Models;

use App\Models\Traits\HasActiveColumn;
use App\Models\Traits\HasQueryBuilder;
use App\Models\Traits\HasTimezones;
use App\Models\Traits\HasTrustedDevices;
use App\Models\Traits\HasTwoFactorAuth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasActiveColumn;
    use HasApiTokens;
    use HasFactory;
    use HasQueryBuilder;
    use HasRolesAndAbilities;
    use HasTimezones;
    use HasTrustedDevices;
    use HasTwoFactorAuth;
    use Notifiable;
    use SoftDeletes;

    protected $default_sorts = ['-active', '-id'];
    protected $allowed_sorts = ['id', 'active'];
    protected $allowed_includes = [];

    protected $fillable = [
        'branch_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'timezone',
        'password_digest',
        'active',
        'profile',
        'has_2fa_enabled',
        'password_updated_at',
    ];

    protected $casts = [
        'active' => 'bool',
        'has_2fa_enabled' => 'bool',
        'deleted' => 'bool',
        'profile' => 'int',
        'password_updated_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'password_digest',
        'remember_token',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted',
    ];

    protected $attributes = [
        'active' => true,
        'profile' => 2,
    ];

    protected $appends = [
        'full_name',
        'role_id',
    ];

    public function forceLogin(): void
    {
        Auth::loginUsingId($this->id);
    }

    public function checkPassword(string $password): bool
    {
        return Hash::check($password, $this->password_digest);
    }

    public function makeSessionToken(): string
    {
        $token = Hash::make(request()->ip().now().$this->id);

        $this->session()->create([
            'token' => $token,
        ]);

        return $token;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function session()
    {
        return $this->hasMany(Session::class);
    }

    public function activeSession()
    {
        return $this->hasOne(Session::class)->active();
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            $query
                ->whereId($text)
                ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$text}%")
                ->orWhere('email', 'like', "%{$text}%");
        });
    }

    public function scopeAccountIs($query, $account = null)
    {
        if (! $account) {
            return $query;
        }

        return $query->whereEmail($account);
    }

    public function scopeFilterByRole($query, $role_id)
    {
        if (! $role_id) {
            return $query;
        }

        if (is_null($role = Role::find($role_id))) {
            return $query->returnNothing();
        }

        return $query->whereIs($role->name);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function getAbilitiesAttribute()
    {
        return $this->getAbilities()->pluck('name');
    }

    public function getRoleIdAttribute()
    {
        $roles = $this->getRoles();

        return Role::whereName($roles->first())->first()?->id;
    }

    public function getRoleAttribute()
    {
        $roles = $this->getRoles();

        return Role::whereName($roles->first())->first();
    }

    public function getPasswordExpiredAttribute(): bool
    {
        if (! $this->can('me.password_expires')) {
            return false;
        }

        if (is_null($this->password_updated_at)) {
            return true;
        }

        return $this->password_updated_at->diffInDays(now()) >= 90;
    }

    protected function passwordDigest(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make($value),
        );
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('undeleted', function ($query) {
            return $query->where('deleted', false);
        });
    }
}
