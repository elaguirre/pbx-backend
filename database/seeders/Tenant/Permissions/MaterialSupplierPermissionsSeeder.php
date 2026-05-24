<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class MaterialSupplierPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Materiales de proveedor',
                'name' => 'material_suppliers.view',
                'title' => 'Ver materiales de proveedor',
                'description' => 'Listar proveedores asignados a materiales.',
            ],
            [
                'group' => 'Materiales de proveedor',
                'name' => 'material_suppliers.add',
                'title' => 'Asignar proveedor a material',
                'description' => 'Vincular proveedores a un material.',
            ],
            [
                'group' => 'Materiales de proveedor',
                'name' => 'material_suppliers.edit',
                'title' => 'Editar materiales de proveedor',
                'description' => 'Modificar precio y asignaciones material-proveedor.',
            ],
            [
                'group' => 'Materiales de proveedor',
                'name' => 'material_suppliers.delete',
                'title' => 'Desasignar proveedor de material',
                'description' => 'Quitar proveedores de un material.',
            ],
        ]);
    }
}
