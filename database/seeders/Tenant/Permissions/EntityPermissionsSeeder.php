<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class EntityPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            ['group' => 'Entidades', 'name' => 'entities.view', 'title' => 'Ver entidades', 'description' => 'Listar y consultar entidades.'],
            ['group' => 'Entidades', 'name' => 'entities.add', 'title' => 'Crear entidades', 'description' => 'Registrar nuevas entidades.'],
            ['group' => 'Entidades', 'name' => 'entities.edit', 'title' => 'Editar entidades', 'description' => 'Modificar entidades existentes.'],
            ['group' => 'Entidades', 'name' => 'entities.delete', 'title' => 'Eliminar entidades', 'description' => 'Eliminar entidades.'],
        ]);
    }
}
