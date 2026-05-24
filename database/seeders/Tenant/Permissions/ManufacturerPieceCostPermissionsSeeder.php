<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ManufacturerPieceCostPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Costo de piezas por maquilador',
                'name' => 'manufacturer_pieces_cost.view',
                'title' => 'Ver costos de pieza',
                'description' => 'Listar costos de mano de obra por pieza y maquilador.',
            ],
            [
                'group' => 'Costo de piezas por maquilador',
                'name' => 'manufacturer_pieces_cost.add',
                'title' => 'Registrar costos de pieza',
                'description' => 'Asignar costo de pieza a un maquilador.',
            ],
            [
                'group' => 'Costo de piezas por maquilador',
                'name' => 'manufacturer_pieces_cost.edit',
                'title' => 'Editar costos de pieza',
                'description' => 'Modificar costos de pieza por maquilador.',
            ],
            [
                'group' => 'Costo de piezas por maquilador',
                'name' => 'manufacturer_pieces_cost.delete',
                'title' => 'Eliminar costos de pieza',
                'description' => 'Quitar costos de pieza de un maquilador.',
            ],
        ]);
    }
}
