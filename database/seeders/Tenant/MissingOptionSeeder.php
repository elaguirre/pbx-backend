<?php

namespace Database\Seeders\Tenant;

use App\Models\MissingsOption;
use Illuminate\Database\Seeder;

class MissingOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MissingsOption::insert([
            [
                "id" => 1,
                "title" => "Retiro de efectivo",
                "active" => true
            ],
            [
                "id" => 2,
                "title" => "Gastos",
                "active" => true
            ],
            [
                "id" => 3,
                "title" => "Nomina",
                "active" => true
            ],
            [
                "id" => 4,
                "title" => "Inversion/Equipo",
                "active" => true
            ],
            [
                "id" => 5,
                "title" => "Faltante",
                "active" => true
            ],
            [
                "id" => 6,
                "title" => "Reembolso",
                "active" => true
            ],
            [
                "id" => 7,
                "title" => "Upgrades/Boletos",
                "active" => true
            ],
            [
                "id" => 8,
                "title" => "Pago inversionista",
                "active" => true
            ],
            [
                "id" => 9,
                "title" => "Almacen Cajero",
                "active" => false
            ],
            [
                "id" => 10,
                "title" => "Boleto Impreso",
                "active" => true
            ]
        ]);
    }
}
