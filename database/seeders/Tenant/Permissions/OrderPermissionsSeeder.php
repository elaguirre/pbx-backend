<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class OrderPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            ['group' => 'Pedidos', 'name' => 'orders.view', 'title' => 'Ver pedidos', 'description' => 'Listar y consultar pedidos.'],
            ['group' => 'Pedidos', 'name' => 'orders.add', 'title' => 'Iniciar pedidos', 'description' => 'Iniciar nuevos pedidos.'],
            ['group' => 'Pedidos', 'name' => 'orders.edit', 'title' => 'Editar pedidos', 'description' => 'Modificar pedidos existentes.'],
            ['group' => 'Pedidos', 'name' => 'orders.delete', 'title' => 'Eliminar pedidos', 'description' => 'Eliminar pedidos.'],
            ['group' => 'Pedidos', 'name' => 'orders.checkout', 'title' => 'Cerrar pedidos', 'description' => 'Finalizar pedidos (checkout).'],
        ]);
    }
}
