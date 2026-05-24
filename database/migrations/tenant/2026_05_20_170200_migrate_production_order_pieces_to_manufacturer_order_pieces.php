<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('production_order_pieces')) {
            return;
        }

        $rows = DB::table('production_order_pieces')->get();

        foreach ($rows as $row) {
            $quantity = DB::table('order_pieces')->where('id', $row->order_piece_id)->value('quantity') ?? 1;

            DB::table('manufacturer_order_pieces')->insert([
                'production_order_id' => $row->production_order_id,
                'order_piece_id' => $row->order_piece_id,
                'quantity' => $quantity,
                'status' => 'pending',
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }

        Schema::dropIfExists('production_order_pieces');
    }

    public function down(): void
    {
        if (Schema::hasTable('production_order_pieces')) {
            return;
        }

        Schema::create('production_order_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders')->cascadeOnDelete();
            $table->foreignId('order_piece_id')->constrained('order_pieces')->cascadeOnDelete();
            $table->timestamps();

            $table->unique('order_piece_id');
        });

        $rows = DB::table('manufacturer_order_pieces')->get();

        foreach ($rows as $row) {
            DB::table('production_order_pieces')->insert([
                'production_order_id' => $row->production_order_id,
                'order_piece_id' => $row->order_piece_id,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }

        Schema::dropIfExists('manufacturer_order_pieces');
    }
};
