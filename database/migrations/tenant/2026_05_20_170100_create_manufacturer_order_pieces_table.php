<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manufacturer_order_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders')->cascadeOnDelete();
            $table->foreignId('order_piece_id')->constrained('order_pieces')->cascadeOnDelete();
            $table->decimal('quantity', 12, 4);
            $table->string('status', 32);
            $table->timestamps();

            $table->unique('order_piece_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacturer_order_pieces');
    }
};
