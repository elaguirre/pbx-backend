<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class CarrierUnitPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Unidades de transporte',
                'name' => 'carrier_units.view',
                'title' => 'Ver unidades',
                'description' => 'Listar unidades de transporte.',
            ],
            [
                'group' => 'Unidades de transporte',
                'name' => 'carrier_units.add',
                'title' => 'Crear unidades',
                'description' => 'Registrar unidades de transporte.',
            ],
            [
                'group' => 'Unidades de transporte',
                'name' => 'carrier_units.edit',
                'title' => 'Editar unidades',
                'description' => 'Modificar unidades de transporte.',
            ],
            [
                'group' => 'Unidades de transporte',
                'name' => 'carrier_units.delete',
                'title' => 'Eliminar unidades',
                'description' => 'Eliminar unidades de transporte.',
            ],
        ]);
    }
}
