<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('drivers', 'carrier_id')) {
            return;
        }

        Schema::table('drivers', function (Blueprint $table) {
            $table->foreignId('carrier_id')->nullable()->after('id')->constrained('carriers')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('drivers', 'carrier_id')) {
            return;
        }

        Schema::table('drivers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('carrier_id');
        });
    }
};
