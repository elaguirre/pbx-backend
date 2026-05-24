<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class CarrierPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Transportistas',
                'name' => 'carriers.view',
                'title' => 'Ver transportistas',
                'description' => 'Listar y consultar transportistas.',
            ],
            [
                'group' => 'Transportistas',
                'name' => 'carriers.add',
                'title' => 'Crear transportistas',
                'description' => 'Registrar nuevos transportistas.',
            ],
            [
                'group' => 'Transportistas',
                'name' => 'carriers.edit',
                'title' => 'Editar transportistas',
                'description' => 'Modificar transportistas existentes.',
            ],
            [
                'group' => 'Transportistas',
                'name' => 'carriers.delete',
                'title' => 'Eliminar transportistas',
                'description' => 'Eliminar transportistas del catálogo.',
            ],
        ]);
    }
}
