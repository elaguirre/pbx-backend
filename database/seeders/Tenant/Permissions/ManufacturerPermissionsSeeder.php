<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ManufacturerPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Maquiladores',
                'name' => 'manufacturers.view',
                'title' => 'Ver maquiladores',
                'description' => 'Listar y consultar maquiladores.',
            ],
            [
                'group' => 'Maquiladores',
                'name' => 'manufacturers.add',
                'title' => 'Crear maquiladores',
                'description' => 'Registrar nuevos maquiladores.',
            ],
            [
                'group' => 'Maquiladores',
                'name' => 'manufacturers.edit',
                'title' => 'Editar maquiladores',
                'description' => 'Modificar maquiladores existentes.',
            ],
            [
                'group' => 'Maquiladores',
                'name' => 'manufacturers.delete',
                'title' => 'Eliminar maquiladores',
                'description' => 'Eliminar maquiladores del catálogo.',
            ],
        ]);
    }
}
