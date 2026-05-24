<?php

namespace App\Providers;

use App\Models\ManufacturingFollowUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::bind('mfg_follow_up', fn (string $value) => ManufacturingFollowUp::query()->findOrFail($value));

        Bouncer::useAbilityModel(\App\Models\Ability::class);
        Bouncer::useRoleModel(\App\Models\Role::class);

        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_ES', 'es', 'ES', 'es_MX.utf8');

        Carbon::macro('toUserTz', static function () {
            return self::this()->copy()->tz(auth()->user()?->timezone ?? config('app.default_timezone_user'));
        });

        Validator::extend('valid_email', function ($attribute, $value) {
            return (bool) preg_match(
                '/^[A-Za-z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[A-Za-z0-9-]+(?:\.[A-Za-z0-9-]+)*$/u',
                $value
            );
        }, 'El campo correo electrónico contiene caracteres no permitidos.');
    }
}
