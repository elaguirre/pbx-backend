<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ManufacturerOrderPiecePermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Piezas en orden de producción',
                'name' => 'manufacturer_order_pieces.view',
                'title' => 'Ver piezas en orden',
                'description' => 'Listar piezas de pedido asignadas a órdenes de producción.',
            ],
            [
                'group' => 'Piezas en orden de producción',
                'name' => 'manufacturer_order_pieces.add',
                'title' => 'Asignar piezas a orden',
                'description' => 'Vincular piezas de pedido a una orden de producción.',
            ],
            [
                'group' => 'Piezas en orden de producción',
                'name' => 'manufacturer_order_pieces.edit',
                'title' => 'Editar piezas en orden',
                'description' => 'Modificar cantidad y estado de piezas en órdenes.',
            ],
            [
                'group' => 'Piezas en orden de producción',
                'name' => 'manufacturer_order_pieces.delete',
                'title' => 'Quitar piezas de orden',
                'description' => 'Eliminar piezas asignadas a una orden de producción.',
            ],
        ]);
    }
}
