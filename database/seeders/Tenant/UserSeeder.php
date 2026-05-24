<?php

namespace Database\Seeders\Tenant;

use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@pbx.local'],
            [
                'branch_id' => 1,
                'first_name' => 'PBX',
                'last_name' => 'Admin',
                'password_digest' => 'password',
                'phone' => null,
                'timezone' => 'America/Mexico_City',
                'active' => true,
                'password_updated_at' => now(),
            ]
        );

        Bouncer::sync($admin)->roles(['root']);
    }
}
