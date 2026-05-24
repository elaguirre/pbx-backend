<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class ContactDataPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            ['group' => 'Contacto', 'name' => 'contact_data.view', 'title' => 'Ver datos de contacto', 'description' => 'Listar y consultar datos de contacto.'],
            ['group' => 'Contacto', 'name' => 'contact_data.add', 'title' => 'Crear datos de contacto', 'description' => 'Registrar datos de contacto.'],
            ['group' => 'Contacto', 'name' => 'contact_data.edit', 'title' => 'Editar datos de contacto', 'description' => 'Modificar datos de contacto.'],
            ['group' => 'Contacto', 'name' => 'contact_data.delete', 'title' => 'Eliminar datos de contacto', 'description' => 'Eliminar datos de contacto.'],
        ]);
    }
}
