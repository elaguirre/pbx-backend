<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carrier_units', function (Blueprint $table) {
            $table->decimal('price_by_volume', 12, 4)->nullable()->after('load_weight_capacity');
            $table->decimal('price_by_weight', 12, 4)->nullable()->after('price_by_volume');
        });
    }

    public function down(): void
    {
        Schema::table('carrier_units', function (Blueprint $table) {
            $table->dropColumn(['price_by_volume', 'price_by_weight']);
        });
    }
};
