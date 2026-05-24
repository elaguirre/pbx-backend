<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_piece_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('details')->nullable();
            $table->string('role')->nullable();
            $table->timestamps();
        });

        $now = now();

        DB::table('order_piece_statuses')->insert([
            [
                'name' => 'Pendiente',
                'details' => 'Pieza generada del pedido, lista para el primer proceso.',
                'role' => 'initial',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'En manufactura',
                'details' => 'Pieza en proceso de construcción o armado.',
                'role' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lista para acabado',
                'details' => 'Manufactura terminada; disponible para pintura u otro acabado.',
                'role' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Terminada',
                'details' => 'Todos los procesos de manufactura completados.',
                'role' => 'shippable',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('order_piece_statuses');
    }
};
