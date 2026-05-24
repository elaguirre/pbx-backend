<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ClientPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            ['group' => 'Clientes', 'name' => 'clients.view', 'title' => 'Ver clientes', 'description' => 'Listar y consultar clientes.'],
            ['group' => 'Clientes', 'name' => 'clients.add', 'title' => 'Crear clientes', 'description' => 'Registrar nuevos clientes.'],
            ['group' => 'Clientes', 'name' => 'clients.edit', 'title' => 'Editar clientes', 'description' => 'Modificar clientes existentes.'],
            ['group' => 'Clientes', 'name' => 'clients.delete', 'title' => 'Eliminar clientes', 'description' => 'Eliminar clientes.'],
        ]);
    }
}
