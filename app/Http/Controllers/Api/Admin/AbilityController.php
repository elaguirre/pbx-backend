<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Route, Middleware, Prefix};

#[Middleware('auth')]
#[Prefix('admin/abilities')]
class AbilityController extends Controller
{
    #[Route('GET', '/', middleware: 'can:users.permissions')]
    public function index(): JsonResponse
    {
        return response()->json(
            Ability::queryBuilder()->resolve()
        );
    }
}
