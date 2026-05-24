<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class PiecePermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Piezas',
                'name' => 'pieces.view',
                'title' => 'Ver piezas',
                'description' => 'Listar y consultar piezas.',
            ],
            [
                'group' => 'Piezas',
                'name' => 'pieces.add',
                'title' => 'Crear piezas',
                'description' => 'Registrar nuevas piezas.',
            ],
            [
                'group' => 'Piezas',
                'name' => 'pieces.edit',
                'title' => 'Editar piezas',
                'description' => 'Modificar piezas existentes.',
            ],
            [
                'group' => 'Piezas',
                'name' => 'pieces.delete',
                'title' => 'Eliminar piezas',
                'description' => 'Eliminar piezas del catálogo.',
            ],
        ]);
    }
}
