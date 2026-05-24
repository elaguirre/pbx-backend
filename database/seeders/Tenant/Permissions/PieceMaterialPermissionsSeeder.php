<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class PieceMaterialPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Materiales de pieza',
                'name' => 'piece_materials.view',
                'title' => 'Ver materiales de pieza',
                'description' => 'Listar materiales asignados a piezas.',
            ],
            [
                'group' => 'Materiales de pieza',
                'name' => 'piece_materials.add',
                'title' => 'Asignar materiales a pieza',
                'description' => 'Vincular materiales a una pieza.',
            ],
            [
                'group' => 'Materiales de pieza',
                'name' => 'piece_materials.edit',
                'title' => 'Editar materiales de pieza',
                'description' => 'Modificar asignaciones pieza-material.',
            ],
            [
                'group' => 'Materiales de pieza',
                'name' => 'piece_materials.delete',
                'title' => 'Desasignar materiales de pieza',
                'description' => 'Quitar materiales de una pieza.',
            ],
        ]);
    }
}
