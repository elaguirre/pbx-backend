<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/settings')]
class SettingController extends Controller
{
    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        $settings = Setting::query()->where('visible_on_web', true)->get();

        return response()->json($settings->pluck('value', 'key')->toArray());
    }

    #[Route('PATCH', '/', middleware: 'can:settings.save')]
    public function update(Request $request): JsonResponse
    {
        $updated = [];
        $notUpdated = [];
        $notFound = [];

        foreach ($request->all() as $key => $value) {
            $setting = Setting::query()->where('key', $key)->first();

            if (! $setting) {
                $notFound[] = $key;
                continue;
            }

            if ($setting->editable) {
                $setting->value = $value;
                $setting->save();
                $updated[] = $key;
            } else {
                $notUpdated[] = $key;
            }
        }

        if (tenant()) {
            Cache::forget('tenant_settings_'.tenant('id'));
        }

        return response()->message('Configuración actualizada.', data: [
            'updated_keys' => $updated,
            'not_updated_keys' => $notUpdated,
            'not_found_keys' => $notFound,
        ]);
    }
}
