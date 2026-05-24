<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class EntityAddressPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Direcciones de entidad',
                'name' => 'entity_addresses.view',
                'title' => 'Ver direcciones',
                'description' => 'Consultar direcciones de entidades.',
            ],
            [
                'group' => 'Direcciones de entidad',
                'name' => 'entity_addresses.add',
                'title' => 'Crear direcciones',
                'description' => 'Registrar direcciones de entidades.',
            ],
            [
                'group' => 'Direcciones de entidad',
                'name' => 'entity_addresses.edit',
                'title' => 'Editar direcciones',
                'description' => 'Modificar direcciones de entidades.',
            ],
            [
                'group' => 'Direcciones de entidad',
                'name' => 'entity_addresses.delete',
                'title' => 'Eliminar direcciones',
                'description' => 'Eliminar direcciones de entidades.',
            ],
        ]);
    }
}
