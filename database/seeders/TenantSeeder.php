<?php

namespace Database\Seeders;

use Database\Seeders\Tenant\BouncerAbilitiesSeeder;
use Database\Seeders\Tenant\BouncerRolesSeeder;
use Database\Seeders\Tenant\BranchSeeder;
use Database\Seeders\Tenant\CitySeeder;
use Database\Seeders\Tenant\OrderPieceStatusSeeder;
use Database\Seeders\Tenant\StateSeeder;
use Database\Seeders\Tenant\SettingSeeder;
use Database\Seeders\Tenant\UserSeeder;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BouncerRolesSeeder::class,
            BouncerAbilitiesSeeder::class,
            OrderPieceStatusSeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            BranchSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
        ]);
    }
}
