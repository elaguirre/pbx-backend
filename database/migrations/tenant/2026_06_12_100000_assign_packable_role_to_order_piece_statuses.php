<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('order_piece_statuses')
            ->where('role', 'packable')
            ->update(['role' => null]);

        DB::table('order_piece_statuses')
            ->where('name', 'Lista para acabado')
            ->update(['role' => 'packable']);
    }

    public function down(): void
    {
        DB::table('order_piece_statuses')
            ->where('name', 'Lista para acabado')
            ->update(['role' => null]);
    }
};
