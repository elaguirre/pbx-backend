<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class SupplierPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Proveedores',
                'name' => 'suppliers.view',
                'title' => 'Ver proveedores',
                'description' => 'Listar y consultar proveedores.',
            ],
            [
                'group' => 'Proveedores',
                'name' => 'suppliers.add',
                'title' => 'Crear proveedores',
                'description' => 'Registrar nuevos proveedores.',
            ],
            [
                'group' => 'Proveedores',
                'name' => 'suppliers.edit',
                'title' => 'Editar proveedores',
                'description' => 'Modificar proveedores existentes.',
            ],
            [
                'group' => 'Proveedores',
                'name' => 'suppliers.delete',
                'title' => 'Eliminar proveedores',
                'description' => 'Eliminar proveedores del catálogo.',
            ],
        ]);
    }
}
