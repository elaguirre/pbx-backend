<?php

namespace Database\Seeders\Tenant;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::query()->updateOrCreate(
            ['id' => 1],
            [
                'branch' => 'Principal',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
