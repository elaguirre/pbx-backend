<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('order_piece_statuses', 'role')) {
            return;
        }

        Schema::table('order_piece_statuses', function (Blueprint $table) {
            $table->string('role')->nullable()->after('details');
        });

        if (Schema::hasColumn('order_piece_statuses', 'is_initial')) {
            DB::table('order_piece_statuses')
                ->where('is_initial', true)
                ->update(['role' => 'initial']);

            DB::table('order_piece_statuses')
                ->where('name', 'Terminada')
                ->update(['role' => 'shippable']);
        }

        Schema::table('order_piece_statuses', function (Blueprint $table) {
            if (Schema::hasColumn('order_piece_statuses', 'is_initial')) {
                $table->dropColumn('is_initial');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('order_piece_statuses', 'role')) {
            return;
        }

        Schema::table('order_piece_statuses', function (Blueprint $table) {
            if (! Schema::hasColumn('order_piece_statuses', 'is_initial')) {
                $table->boolean('is_initial')->default(false)->after('details');
            }
        });

        DB::table('order_piece_statuses')->where('role', 'initial')->update(['is_initial' => true]);
        DB::table('order_piece_statuses')->where('role', '!=', 'initial')->update(['is_initial' => false]);

        Schema::table('order_piece_statuses', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
