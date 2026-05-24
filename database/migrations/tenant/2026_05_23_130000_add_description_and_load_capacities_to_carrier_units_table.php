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

        Schema::table('carrier_units', function (Blueprint $table) {
            $table->text('description')->nullable()->after('carrier_id');
            $table->decimal('load_volume_capacity', 12, 4)->nullable()->after('description');
            $table->decimal('load_weight_capacity', 12, 4)->nullable()->after('load_volume_capacity');
        });

        if (Schema::hasColumn('carrier_units', 'size')) {
            DB::table('carrier_units')
                ->whereNull('description')
                ->whereNotNull('size')
                ->update(['description' => DB::raw('size')]);
        }

        if (Schema::hasColumn('carrier_units', 'load_capacity')) {
            DB::table('carrier_units')
                ->whereNull('load_weight_capacity')
                ->whereNotNull('load_capacity')
                ->update(['load_weight_capacity' => DB::raw('load_capacity')]);
        }
    }

    public function down(): void
    {
        Schema::table('carrier_units', function (Blueprint $table) {
            $table->dropColumn(['description', 'load_volume_capacity', 'load_weight_capacity']);
        });
    }
};
