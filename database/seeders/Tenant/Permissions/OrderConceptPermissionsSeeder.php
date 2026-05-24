<?php

namespace Database\Seeders\Tenant\Permissions;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Illuminate\Database\Seeder;

class OrderConceptPermissionsSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->upsertAbilities([
            ['group' => 'Conceptos de pedido', 'name' => 'order_concepts.view', 'title' => 'Ver conceptos', 'description' => 'Listar conceptos de pedido.'],
            ['group' => 'Conceptos de pedido', 'name' => 'order_concepts.add', 'title' => 'Agregar conceptos', 'description' => 'Agregar líneas al pedido.'],
            ['group' => 'Conceptos de pedido', 'name' => 'order_concepts.edit', 'title' => 'Editar conceptos', 'description' => 'Modificar líneas del pedido.'],
            ['group' => 'Conceptos de pedido', 'name' => 'order_concepts.delete', 'title' => 'Eliminar conceptos', 'description' => 'Quitar líneas del pedido.'],
        ]);
    }
}
