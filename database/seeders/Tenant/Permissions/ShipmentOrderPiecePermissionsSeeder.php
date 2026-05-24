<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ShipmentOrderPiecePermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Piezas del embarque',
                'name' => 'shipment_order_pieces.view',
                'title' => 'Ver piezas del embarque',
                'description' => 'Consultar piezas asignadas a embarques.',
            ],
            [
                'group' => 'Piezas del embarque',
                'name' => 'shipment_order_pieces.add',
                'title' => 'Agregar piezas al embarque',
                'description' => 'Asignar piezas de pedido a un embarque.',
            ],
            [
                'group' => 'Piezas del embarque',
                'name' => 'shipment_order_pieces.edit',
                'title' => 'Editar piezas del embarque',
                'description' => 'Modificar cantidades en el embarque.',
            ],
            [
                'group' => 'Piezas del embarque',
                'name' => 'shipment_order_pieces.delete',
                'title' => 'Quitar piezas del embarque',
                'description' => 'Eliminar piezas de un embarque.',
            ],
        ]);
    }
}
