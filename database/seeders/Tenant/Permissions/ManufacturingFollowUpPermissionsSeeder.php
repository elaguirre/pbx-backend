<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ManufacturingFollowUpPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Seguimiento de manufactura',
                'name' => 'manufacturing_follow_up.view',
                'title' => 'Ver seguimiento de manufactura',
                'description' => 'Consultar avances y reportes del proceso de manufactura.',
            ],
            [
                'group' => 'Seguimiento de manufactura',
                'name' => 'manufacturing_follow_up.add',
                'title' => 'Registrar seguimiento de manufactura',
                'description' => 'Registrar piezas completadas, canceladas o seguimientos informativos.',
            ],
            [
                'group' => 'Seguimiento de manufactura',
                'name' => 'manufacturing_follow_up.edit',
                'title' => 'Editar seguimiento de manufactura',
                'description' => 'Modificar registros de seguimiento de manufactura.',
            ],
            [
                'group' => 'Seguimiento de manufactura',
                'name' => 'manufacturing_follow_up.delete',
                'title' => 'Eliminar seguimiento de manufactura',
                'description' => 'Eliminar registros de seguimiento de manufactura.',
            ],
        ]);
    }
}
