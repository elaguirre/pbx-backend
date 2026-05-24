<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class OrderPieceStatusPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Estados de pieza',
                'name' => 'order_piece_statuses.view',
                'title' => 'Ver estados de pieza',
                'description' => 'Listar y consultar estados de piezas de pedido.',
            ],
            [
                'group' => 'Estados de pieza',
                'name' => 'order_piece_statuses.add',
                'title' => 'Crear estados de pieza',
                'description' => 'Registrar nuevos estados de piezas de pedido.',
            ],
            [
                'group' => 'Estados de pieza',
                'name' => 'order_piece_statuses.edit',
                'title' => 'Editar estados de pieza',
                'description' => 'Modificar estados de piezas de pedido.',
            ],
            [
                'group' => 'Estados de pieza',
                'name' => 'order_piece_statuses.delete',
                'title' => 'Eliminar estados de pieza',
                'description' => 'Eliminar estados de piezas de pedido.',
            ],
        ]);
    }
}
