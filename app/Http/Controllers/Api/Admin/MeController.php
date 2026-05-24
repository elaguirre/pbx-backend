<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Get, Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/me')]
class MeController extends Controller
{
    #[Get('/')]
    public function __invoke(): JsonResponse
    {
        $user = auth()->user()->append(['abilities', 'role', 'password_expired']);

        return response()->json($user);
    }

    #[Route('POST', 'change-password')]
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        auth()->user()->update(['password_digest' => $request->get('password')]);
        auth()->user()->touch('password_updated_at');

        return response()->message('Contraseña actualizada correctamente.');
    }

}
