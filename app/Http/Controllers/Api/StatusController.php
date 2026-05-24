<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Route;

class StatusController extends Controller
{
    #[Route('GET', 'status')]
    public function __invoke()
    {
        return response()->message('ok');
    }

    #[Route('GET', 'tenant')]
    public function tenant()
    {
        return response()->json([
            'tenant' => tenant('id'),
            'name' => config('app.title', config('site.name')),
        ]);
    }
}
