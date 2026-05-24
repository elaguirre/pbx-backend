<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('items') && ! Schema::hasTable('products')) {
            Schema::rename('items', 'products');
        }

        if (Schema::hasTable('products') && ! Schema::hasColumn('products', 'price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('price', 12, 2)->default(0)->after('name');
            });
        }

        if (! Schema::hasTable('order_concepts') || ! Schema::hasColumn('order_concepts', 'item_id')) {
            return;
        }

        Schema::table('order_concepts', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
        });

        Schema::table('order_concepts', function (Blueprint $table) {
            $table->renameColumn('item_id', 'product_id');
        });

        Schema::table('order_concepts', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('order_concepts') && Schema::hasColumn('order_concepts', 'product_id')) {
            Schema::table('order_concepts', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
            });

            Schema::table('order_concepts', function (Blueprint $table) {
                $table->renameColumn('product_id', 'item_id');
            });

            Schema::table('order_concepts', function (Blueprint $table) {
                $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('price');
            });
        }

        if (Schema::hasTable('products') && ! Schema::hasTable('items')) {
            Schema::rename('products', 'items');
        }
    }
};
