<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('order_concept_id')->constrained('order_concepts')->cascadeOnDelete();
            $table->foreignId('piece_id')->constrained('pieces')->cascadeOnDelete();
            $table->decimal('quantity', 12, 4);
            $table->timestamps();

            $table->unique(['order_concept_id', 'piece_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_pieces');
    }
};
