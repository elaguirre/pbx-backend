<?php

namespace App\Providers;

use App\Models\Session;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        Auth::viaRequest('pbx-token', function ($request) {
            $token = $request->bearerToken() ?: $request->get('token');

            $session = Session::active()->isAdminSession()->tokenIs($token)->first();

            if (is_null($session) || is_null($user = $session->user)) {
                return null;
            }

            $session->extendTokenLife();

            return $user;
        });
    }
}
