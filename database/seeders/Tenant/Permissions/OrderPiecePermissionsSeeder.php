<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class OrderPiecePermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Piezas de pedido',
                'name' => 'order_pieces.view',
                'title' => 'Ver piezas de pedido',
                'description' => 'Listar piezas a fabricar de un pedido.',
            ],
            [
                'group' => 'Piezas de pedido',
                'name' => 'order_pieces.add',
                'title' => 'Agregar piezas de pedido',
                'description' => 'Registrar piezas a fabricar en un pedido.',
            ],
            [
                'group' => 'Piezas de pedido',
                'name' => 'order_pieces.edit',
                'title' => 'Editar piezas de pedido',
                'description' => 'Modificar piezas a fabricar de un pedido.',
            ],
            [
                'group' => 'Piezas de pedido',
                'name' => 'order_pieces.delete',
                'title' => 'Eliminar piezas de pedido',
                'description' => 'Quitar piezas registradas en un pedido.',
            ],
        ]);
    }
}
