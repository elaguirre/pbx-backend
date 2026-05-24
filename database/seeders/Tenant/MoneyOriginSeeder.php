<?php

namespace Database\Seeders\Tenant;

use App\Models\MoneyOrigin;
use Illuminate\Database\Seeder;

class MoneyOriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        MoneyOrigin::insert([
            [
                "name" => "Tarjeta de crédito",
                "active" => true,
                "is_reportable" => true,
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                "name" => "Cuenta Bancaria",
                "active" => true,
                "is_reportable" => true,
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }
}
