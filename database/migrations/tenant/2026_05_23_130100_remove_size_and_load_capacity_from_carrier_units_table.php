<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carrier_units', function (Blueprint $table) {
            if (Schema::hasColumn('carrier_units', 'load_capacity')) {
                $table->dropColumn('load_capacity');
            }

            if (Schema::hasColumn('carrier_units', 'size')) {
                $table->dropColumn('size');
            }
        });
    }

    public function down(): void
    {
        Schema::table('carrier_units', function (Blueprint $table) {
            if (! Schema::hasColumn('carrier_units', 'size')) {
                $table->string('size')->nullable()->after('carrier_id');
            }

            if (! Schema::hasColumn('carrier_units', 'load_capacity')) {
                $table->decimal('load_capacity', 12, 4)->nullable()->after('size');
            }
        });
    }
};
