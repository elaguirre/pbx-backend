<?php

namespace Database\Seeders\Tenant;

use App\Models\PrintedMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrintedMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $printed_methods = collect([
            [
                'name' => 'Boleto físico',
                'description' => 'El usuario debe ir a algún punto de venta a imprimir el boleto.',
                'active' => 1,
            ],
            [
                'name' => 'Boleto digital',
                'description' => 'El usuario debe descargar la app de wallet para poder imprimir el boleto.',
                'active' => 0,
            ],
            [
                'name' => 'Boleto en PDF',
                'description' => 'Se envían los boletos en formato PDF al correo de confirmación de compra.',
                'active' => 1,
            ],
            [
                'name' => 'Boleto en versión web',
                'description' => 'Se le envía una liga al usuario por correo donde podrá ver sus boletos.',
                'active' => 0,
            ],
        ]);

        $printed_methods->map(fn($printed_method) => PrintedMethod::updateOrCreate($printed_method));
    }
}
