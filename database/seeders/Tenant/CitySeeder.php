<?php

namespace Database\Seeders\Tenant;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = require database_path('data/mexico_cities.php');

        foreach (array_chunk($cities, 500) as $chunk) {
            City::query()->upsert($chunk, ['id'], ['name', 'state_id']);
        }
    }
}
