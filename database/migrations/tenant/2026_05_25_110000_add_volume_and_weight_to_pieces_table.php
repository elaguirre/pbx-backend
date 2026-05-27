<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pieces', function (Blueprint $table) {
            $table->decimal('volume', 12, 4)->nullable()->after('name');
            $table->decimal('weight', 12, 4)->nullable()->after('volume');
        });
    }

    public function down(): void
    {
        Schema::table('pieces', function (Blueprint $table) {
            $table->dropColumn(['volume', 'weight']);
        });
    }
};
