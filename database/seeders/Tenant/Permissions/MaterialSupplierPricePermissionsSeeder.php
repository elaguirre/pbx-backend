<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class MaterialSupplierPricePermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Precios de proveedor',
                'name' => 'material_supplier_prices.view',
                'title' => 'Ver precios de proveedor',
                'description' => 'Consultar historial de precios por material y proveedor.',
            ],
            [
                'group' => 'Precios de proveedor',
                'name' => 'material_supplier_prices.add',
                'title' => 'Registrar precios de proveedor',
                'description' => 'Dar de alta nuevos precios en el historial.',
            ],
            [
                'group' => 'Precios de proveedor',
                'name' => 'material_supplier_prices.edit',
                'title' => 'Editar precios de proveedor',
                'description' => 'Modificar precios del historial.',
            ],
            [
                'group' => 'Precios de proveedor',
                'name' => 'material_supplier_prices.delete',
                'title' => 'Eliminar precios de proveedor',
                'description' => 'Eliminar registros del historial de precios.',
            ],
        ]);
    }
}
