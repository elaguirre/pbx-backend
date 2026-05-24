<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class DriverPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Conductores',
                'name' => 'drivers.view',
                'title' => 'Ver conductores',
                'description' => 'Listar y consultar conductores.',
            ],
            [
                'group' => 'Conductores',
                'name' => 'drivers.add',
                'title' => 'Crear conductores',
                'description' => 'Registrar nuevos conductores.',
            ],
            [
                'group' => 'Conductores',
                'name' => 'drivers.edit',
                'title' => 'Editar conductores',
                'description' => 'Modificar conductores existentes.',
            ],
            [
                'group' => 'Conductores',
                'name' => 'drivers.delete',
                'title' => 'Eliminar conductores',
                'description' => 'Eliminar conductores del catálogo.',
            ],
        ]);
    }
}
