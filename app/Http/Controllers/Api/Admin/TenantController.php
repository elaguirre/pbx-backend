<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/tenants')]
class TenantController extends Controller
{
    #[Route('GET', '/', middleware: 'can:tenants.access')]
    public function index(): JsonResponse
    {
        return response()->json(Tenant::all());
    }

}
