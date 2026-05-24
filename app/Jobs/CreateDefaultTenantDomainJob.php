<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class CreateDefaultTenantDomainJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected TenantWithDatabase $tenant) {}

    public function handle(): void
    {
        try {
            $this->tenant->domains()->create([
                'domain' => $this->getTenantDefaultDomain($this->tenant->getTenantKey()),
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }

    private function getTenantDefaultDomain(string $tenantKey): string
    {
        if (app()->environment('production')) {
            return "api-{$tenantKey}.pbx.app";
        }

        return "api-{$tenantKey}.pbx-back.test";
    }
}
