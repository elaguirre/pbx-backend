<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ProductionBatchPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Lotes de producción',
                'name' => 'production_batches.view',
                'title' => 'Ver lotes de producción',
                'description' => 'Listar lotes de producción.',
            ],
            [
                'group' => 'Lotes de producción',
                'name' => 'production_batches.add',
                'title' => 'Crear lotes de producción',
                'description' => 'Registrar nuevos lotes de producción.',
            ],
            [
                'group' => 'Lotes de producción',
                'name' => 'production_batches.edit',
                'title' => 'Editar lotes de producción',
                'description' => 'Modificar lotes de producción.',
            ],
            [
                'group' => 'Lotes de producción',
                'name' => 'production_batches.delete',
                'title' => 'Eliminar lotes de producción',
                'description' => 'Eliminar lotes de producción.',
            ],
        ]);
    }
}
