<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_piece_statuses', function (Blueprint $table) {
            $table->unsignedInteger('order')->default(0)->after('role');
        });

        $rows = DB::table('order_piece_statuses')->orderBy('id')->get();

        foreach ($rows as $index => $row) {
            DB::table('order_piece_statuses')
                ->where('id', $row->id)
                ->update(['order' => ($index + 1) * 10]);
        }
    }

    public function down(): void
    {
        Schema::table('order_piece_statuses', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
