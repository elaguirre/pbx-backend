<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipment_order_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete();
            $table->foreignId('order_piece_id')->constrained('order_pieces')->restrictOnDelete();
            $table->decimal('quantity', 12, 4);
            $table->timestamps();

            $table->unique(['shipment_id', 'order_piece_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_order_pieces');
    }
};
