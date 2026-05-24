<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ShipmentRoutePermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Rutas de embarque',
                'name' => 'shipment_routes.view',
                'title' => 'Ver rutas de embarque',
                'description' => 'Consultar el recorrido de entrega del embarque.',
            ],
            [
                'group' => 'Rutas de embarque',
                'name' => 'shipment_routes.add',
                'title' => 'Agregar paradas de ruta',
                'description' => 'Registrar paradas en la ruta del embarque.',
            ],
            [
                'group' => 'Rutas de embarque',
                'name' => 'shipment_routes.edit',
                'title' => 'Editar rutas de embarque',
                'description' => 'Reordenar y modificar paradas de la ruta.',
            ],
            [
                'group' => 'Rutas de embarque',
                'name' => 'shipment_routes.delete',
                'title' => 'Eliminar paradas de ruta',
                'description' => 'Quitar paradas de la ruta del embarque.',
            ],
        ]);
    }
}
