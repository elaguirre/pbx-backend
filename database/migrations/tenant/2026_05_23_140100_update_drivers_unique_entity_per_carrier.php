<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('drivers', 'carrier_id')) {
            return;
        }

        $indexes = collect(Schema::getIndexes('drivers'));
        $hasEntityOnlyUnique = $indexes->contains(
            fn (array $index) => count($index['columns']) === 1 && $index['columns'][0] === 'entity_id',
        );
        $hasCarrierEntityUnique = $indexes->contains(
            fn (array $index) => $index['columns'] === ['carrier_id', 'entity_id'],
        );

        if (! $hasEntityOnlyUnique || $hasCarrierEntityUnique) {
            return;
        }

        Schema::table('drivers', function (Blueprint $table) {
            $table->unique(['carrier_id', 'entity_id']);
            $table->index('entity_id');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->dropUnique(['entity_id']);
        });
    }

    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->unique('entity_id');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->dropUnique(['carrier_id', 'entity_id']);
            $table->dropIndex(['entity_id']);
        });
    }
};
