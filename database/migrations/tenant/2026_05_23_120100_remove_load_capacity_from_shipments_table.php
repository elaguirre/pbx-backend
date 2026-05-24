<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('shipments', 'load_capacity')) {
            Schema::table('shipments', function (Blueprint $table) {
                $table->dropColumn('load_capacity');
            });
        }
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->decimal('load_capacity', 12, 4)->nullable()->after('carrier_unit_id');
        });
    }
};
