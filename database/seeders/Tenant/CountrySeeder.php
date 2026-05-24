<?php

namespace Database\Seeders\Tenant;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::insert([
            'country' => 'México',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
