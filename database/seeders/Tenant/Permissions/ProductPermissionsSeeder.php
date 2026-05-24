<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ProductPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Productos',
                'name' => 'products.view',
                'title' => 'Ver productos',
                'description' => 'Listar y consultar productos.',
            ],
            [
                'group' => 'Productos',
                'name' => 'products.add',
                'title' => 'Crear productos',
                'description' => 'Registrar nuevos productos.',
            ],
            [
                'group' => 'Productos',
                'name' => 'products.edit',
                'title' => 'Editar productos',
                'description' => 'Modificar productos existentes.',
            ],
            [
                'group' => 'Productos',
                'name' => 'products.delete',
                'title' => 'Eliminar productos',
                'description' => 'Eliminar productos del catálogo.',
            ],
        ]);
    }
}
