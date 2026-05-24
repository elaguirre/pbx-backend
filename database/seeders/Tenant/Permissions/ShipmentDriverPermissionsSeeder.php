<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ShipmentDriverPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Conductores del embarque',
                'name' => 'shipment_drivers.view',
                'title' => 'Ver conductores del embarque',
                'description' => 'Consultar conductores asignados al embarque.',
            ],
            [
                'group' => 'Conductores del embarque',
                'name' => 'shipment_drivers.add',
                'title' => 'Asignar conductores',
                'description' => 'Asignar conductores a un embarque.',
            ],
            [
                'group' => 'Conductores del embarque',
                'name' => 'shipment_drivers.edit',
                'title' => 'Editar asignaciones',
                'description' => 'Modificar conductores del embarque.',
            ],
            [
                'group' => 'Conductores del embarque',
                'name' => 'shipment_drivers.delete',
                'title' => 'Quitar conductores',
                'description' => 'Eliminar conductores del embarque.',
            ],
        ]);
    }
}
