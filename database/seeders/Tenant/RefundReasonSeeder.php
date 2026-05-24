<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\RefundReason;

class RefundReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        RefundReason::insert([
            [
                'id' => 1,
                'name' => 'Cambio de recinto',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Cambio de fecha',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Cancelación del evento',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Error del sistema',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Otro',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
