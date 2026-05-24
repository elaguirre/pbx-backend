<?php

namespace App\Tenancy\Bootstrap;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;

class LoadTenantSettings implements TenancyBootstrapper
{
    /**
     * @param \Stancl\Tenancy\Contracts\Tenant $tenant
     * @return void
     */
    public function bootstrap(Tenant $tenant): void
    {
        try {
            $settings = Cache::rememberForever('tenant_settings_' . $tenant->id, function () use ($tenant) {
                return Setting::query()
                    ->whereNotNull('value')
                    ->pluck('value', 'key')
                    ->toArray();
            });

            Config::set($settings);
        } catch (\Throwable $exception) {
            Log::error('Error loading tenant settings', [
                'tenant_id' => $tenant->id,
                'exception' => $exception,
            ]);
        }
    }

    public function revert(): void
    {

    }
}
