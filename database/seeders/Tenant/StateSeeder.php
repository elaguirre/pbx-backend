<?php

namespace Database\Seeders\Tenant;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = require database_path('data/mexico_states.php');

        State::query()->upsert($states, ['id'], ['name']);
    }
}
