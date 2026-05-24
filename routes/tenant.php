<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Features\UserImpersonation;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;

Route::middleware([
    InitializeTenancyByRequestData::class,
])->group(function () {
    Route::get('/tenant', function () {
        return response()->json([
            'tenant_id' => tenant('id'),
        ]);
    });

    Route::get('/impersonate/{token}', function ($token) {
        return UserImpersonation::makeResponse($token);
    });
});

Route::get('/status', [App\Http\Controllers\Api\StatusController::class, '__invoke']);

foreach (config('tenancy.central_domains') as $domain) {
    Route::any('/', function () {
        return response()->message('PBX API', 404);
    });
}
