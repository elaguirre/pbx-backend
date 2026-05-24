<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ProductionOrderPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Órdenes de producción',
                'name' => 'production_orders.view',
                'title' => 'Ver órdenes de producción',
                'description' => 'Listar órdenes de trabajo de maquiladores.',
            ],
            [
                'group' => 'Órdenes de producción',
                'name' => 'production_orders.add',
                'title' => 'Crear órdenes de producción',
                'description' => 'Registrar órdenes de trabajo para un maquilador.',
            ],
            [
                'group' => 'Órdenes de producción',
                'name' => 'production_orders.edit',
                'title' => 'Editar órdenes de producción',
                'description' => 'Modificar órdenes de trabajo.',
            ],
            [
                'group' => 'Órdenes de producción',
                'name' => 'production_orders.delete',
                'title' => 'Eliminar órdenes de producción',
                'description' => 'Eliminar órdenes de trabajo.',
            ],
        ]);
    }
}
