<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class MaterialPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Materiales',
                'name' => 'materials.view',
                'title' => 'Ver materiales',
                'description' => 'Listar y consultar materiales.',
            ],
            [
                'group' => 'Materiales',
                'name' => 'materials.add',
                'title' => 'Crear materiales',
                'description' => 'Registrar nuevos materiales.',
            ],
            [
                'group' => 'Materiales',
                'name' => 'materials.edit',
                'title' => 'Editar materiales',
                'description' => 'Modificar materiales existentes.',
            ],
            [
                'group' => 'Materiales',
                'name' => 'materials.delete',
                'title' => 'Eliminar materiales',
                'description' => 'Eliminar materiales del catálogo.',
            ],
        ]);
    }
}
