<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->decimal('price', 12, 2)->default(0);
            $table->timestamps();

            $table->unique(['material_id', 'supplier_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_suppliers');
    }
};
