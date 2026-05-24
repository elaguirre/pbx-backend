<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\RouteAttributes\Attributes\{Post, Prefix};

#[Prefix('admin/login')]
class LoginController extends Controller
{
    #[Post('/')]
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = User::accountIs($request->email)->active()->first();
        if (is_null($user) || !$user->checkPassword($request->password)) {
            return response()->message('Los datos ingresados son inválidos, por favor intenta nuevamente.', 400);
        }

        if (app()->environment('production') && $user->can('me.require_2fa') && !$user->isTrustedDevice($request->header('X-Fingerprint-Device'))) {
            if (!$user->phone) {
                return response()->message('2FA: Esta cuenta no tiene un celular ligado, por favor contacta a un administrador.', 400);
            }

            if (!$request->input('two_fa_token')) {
                $user->send2faCode();

                return response()->json(['require_2fa' => true], 400);
            }

            if (!$user->check2fa($request->input('two_fa_token'))) {
                return response()->message('El código de autenticación de dos factores es inválido.', 400);
            }

            if ($request->remember && $request->header('X-Fingerprint-Device')) {
                $user->createTrustedDevice($request->header('X-Fingerprint-Device'));
            }

            $user->notify(new \App\Notifications\LoginNotification(
                ip: request()->ip(),
                browser: request()->header('User-Agent')
            ));
        }

        return response()->json(['token' => $user->makeSessionToken()]);
    }

    #[Post('/resend-2fa')]
    public function resend2Fa(Request $request): JsonResponse
    {
        $user = User::accountIs($request->email)->active()->first();

        // TODO: Check if user has active 2fa code

        $user?->send2faCode();

        return response()->message('Se envió un nuevo código exitosamente.');
    }
}
