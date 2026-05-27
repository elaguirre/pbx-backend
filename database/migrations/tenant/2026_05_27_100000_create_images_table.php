<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('images')) {
            return;
        }

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable');
            $table->string('type');
            $table->string('path');
            $table->timestamps();

            $table->unique(['imageable_type', 'imageable_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
