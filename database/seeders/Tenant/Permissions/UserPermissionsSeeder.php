<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class UserPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            [
                'group' => 'Usuarios',
                'name' => 'users.view',
                'title' => 'Ver usuarios',
                'description' => 'Listar y consultar usuarios.',
            ],
            [
                'group' => 'Usuarios',
                'name' => 'users.add',
                'title' => 'Crear usuarios',
                'description' => 'Registrar nuevos usuarios.',
            ],
            [
                'group' => 'Usuarios',
                'name' => 'users.edit',
                'title' => 'Editar usuarios',
                'description' => 'Modificar datos de usuarios.',
            ],
            [
                'group' => 'Usuarios',
                'name' => 'users.delete',
                'title' => 'Eliminar usuarios',
                'description' => 'Eliminar usuarios del sistema.',
            ],
            [
                'group' => 'Usuarios',
                'name' => 'users.permissions',
                'title' => 'Asignar permisos',
                'description' => 'Gestionar permisos específicos de un usuario.',
            ],
        ]);
    }
}
