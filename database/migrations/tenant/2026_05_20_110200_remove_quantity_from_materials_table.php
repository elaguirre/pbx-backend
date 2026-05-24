<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('materials', 'quantity')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('materials', 'quantity')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->decimal('quantity', 12, 4)->default(0)->after('uom');
            });
        }
    }
};
