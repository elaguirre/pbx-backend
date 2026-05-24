<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ProductPiecePermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Piezas de producto',
                'name' => 'product_pieces.view',
                'title' => 'Ver piezas de producto',
                'description' => 'Listar piezas asignadas a productos.',
            ],
            [
                'group' => 'Piezas de producto',
                'name' => 'product_pieces.add',
                'title' => 'Asignar piezas a producto',
                'description' => 'Vincular piezas a un producto.',
            ],
            [
                'group' => 'Piezas de producto',
                'name' => 'product_pieces.edit',
                'title' => 'Editar piezas de producto',
                'description' => 'Modificar asignaciones producto-pieza.',
            ],
            [
                'group' => 'Piezas de producto',
                'name' => 'product_pieces.delete',
                'title' => 'Desasignar piezas de producto',
                'description' => 'Quitar piezas de un producto.',
            ],
        ]);
    }
}
