<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ShipmentPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Embarques',
                'name' => 'shipments.view',
                'title' => 'Ver embarques',
                'description' => 'Listar y consultar embarques.',
            ],
            [
                'group' => 'Embarques',
                'name' => 'shipments.add',
                'title' => 'Crear embarques',
                'description' => 'Registrar nuevos embarques.',
            ],
            [
                'group' => 'Embarques',
                'name' => 'shipments.edit',
                'title' => 'Editar embarques',
                'description' => 'Modificar embarques existentes.',
            ],
            [
                'group' => 'Embarques',
                'name' => 'shipments.delete',
                'title' => 'Eliminar embarques',
                'description' => 'Eliminar embarques.',
            ],
        ]);
    }
}
