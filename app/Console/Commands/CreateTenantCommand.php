<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

class CreateTenantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:create {tenant_name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tenant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (empty($tenant_name = $this->argument('tenant_name'))) {
            $tenant_name = $this->askTenantName();
        }

        Tenant::create(['id' => $tenant_name]);

        $this->info("Tenant '$tenant_name' created successfully.");

        return 0;
    }

    private function askTenantName(): string
    {
        do {
            $tenant_name = $this->ask('Please enter the tenant name');
        } while (!$tenant_name);

        return $tenant_name;
    }
}
