<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasNonUniqueIndex = collect(DB::select(
            'SHOW INDEX FROM manufacturer_order_pieces WHERE Column_name = ? AND Non_unique = 1',
            ['order_piece_id'],
        ))->isNotEmpty();

        if (! $hasNonUniqueIndex) {
            Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
                $table->index('order_piece_id', 'manufacturer_order_pieces_order_piece_id_index');
            });
        }

        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            $table->dropUnique(['order_piece_id']);
            $table->unique(
                ['production_order_id', 'order_piece_id'],
                'manufacturer_order_pieces_production_order_order_piece_unique',
            );
        });
    }

    public function down(): void
    {
        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            $table->dropUnique('manufacturer_order_pieces_production_order_order_piece_unique');
            $table->unique('order_piece_id');
        });

        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            $table->dropIndex('manufacturer_order_pieces_order_piece_id_index');
        });
    }
};
