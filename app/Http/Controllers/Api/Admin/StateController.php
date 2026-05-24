<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/states')]
class StateController extends Controller
{
    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        return response()->json(State::queryBuilder()->resolve());
    }
}
