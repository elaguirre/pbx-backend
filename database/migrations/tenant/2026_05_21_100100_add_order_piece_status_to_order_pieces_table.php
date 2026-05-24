<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_pieces', function (Blueprint $table) {
            $table->foreignId('order_piece_status_id')
                ->nullable()
                ->after('quantity')
                ->constrained('order_piece_statuses')
                ->nullOnDelete();
        });

        $initialId = DB::table('order_piece_statuses')->where('role', 'initial')->value('id')
            ?? DB::table('order_piece_statuses')->orderBy('id')->value('id');

        if ($initialId) {
            DB::table('order_pieces')
                ->whereNull('order_piece_status_id')
                ->update(['order_piece_status_id' => $initialId]);
        }
    }

    public function down(): void
    {
        Schema::table('order_pieces', function (Blueprint $table) {
            $table->dropConstrainedForeignId('order_piece_status_id');
        });
    }
};
