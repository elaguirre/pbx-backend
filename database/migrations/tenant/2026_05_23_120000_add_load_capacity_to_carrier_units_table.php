<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('carrier_units', 'description')) {
            return;
        }

        if (Schema::hasColumn('carrier_units', 'load_capacity')) {
            return;
        }

        Schema::table('carrier_units', function (Blueprint $table) {
            $table->decimal('load_capacity', 12, 4)->nullable()->after('size');
        });

        if (Schema::hasColumn('shipments', 'load_capacity')) {
            DB::statement('
                UPDATE carrier_units cu
                INNER JOIN shipments s ON s.carrier_unit_id = cu.id
                SET cu.load_capacity = s.load_capacity
                WHERE s.load_capacity IS NOT NULL
            ');
        }
    }

    public function down(): void
    {
        Schema::table('carrier_units', function (Blueprint $table) {
            $table->dropColumn('load_capacity');
        });
    }
};
