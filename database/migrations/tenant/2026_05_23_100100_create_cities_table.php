<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->primary();
            $table->string('name');
            $table->unsignedSmallInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->restrictOnDelete();
            $table->index('state_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
