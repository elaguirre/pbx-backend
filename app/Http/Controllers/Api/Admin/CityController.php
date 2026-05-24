<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/cities')]
class CityController extends Controller
{
    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        return response()->json(City::queryBuilder()->resolve());
    }
}
