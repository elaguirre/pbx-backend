<?php

namespace Database\Seeders\Tenant;

use App\Models\OrderPieceStatus;
use Illuminate\Database\Seeder;

class OrderPieceStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Pendiente',
                'details' => 'Pieza generada del pedido, lista para el primer proceso.',
                'role' => 'initial',
                'order' => 10,
            ],
            [
                'name' => 'En manufactura',
                'details' => 'Pieza en proceso de construcción o armado.',
                'role' => null,
                'order' => 20,
            ],
            [
                'name' => 'Lista para acabado',
                'details' => 'Manufactura terminada; disponible para pintura u otro acabado.',
                'role' => null,
                'order' => 30,
            ],
            [
                'name' => 'Terminada',
                'details' => 'Todos los procesos de manufactura completados.',
                'role' => 'shippable',
                'order' => 40,
            ],
        ];

        foreach ($statuses as $status) {
            OrderPieceStatus::query()->updateOrCreate(
                ['name' => $status['name']],
                $status,
            );
        }
    }
}
