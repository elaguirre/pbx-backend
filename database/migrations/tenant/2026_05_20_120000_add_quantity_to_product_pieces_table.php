<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('product_pieces', 'quantity')) {
            Schema::table('product_pieces', function (Blueprint $table) {
                $table->decimal('quantity', 12, 4)->default(1)->after('piece_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('product_pieces', 'quantity')) {
            Schema::table('product_pieces', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }
    }
};
