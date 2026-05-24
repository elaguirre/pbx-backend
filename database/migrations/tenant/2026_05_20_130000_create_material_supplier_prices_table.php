<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_supplier_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_supplier_id')->constrained('material_suppliers')->cascadeOnDelete();
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });

        if (Schema::hasColumn('material_suppliers', 'price')) {
            foreach (DB::table('material_suppliers')->orderBy('id')->get() as $row) {
                DB::table('material_supplier_prices')->insert([
                    'material_supplier_id' => $row->id,
                    'price' => $row->price,
                    'created_at' => $row->updated_at ?? $row->created_at ?? now(),
                    'updated_at' => $row->updated_at ?? $row->created_at ?? now(),
                ]);
            }

            Schema::table('material_suppliers', function (Blueprint $table) {
                $table->dropColumn('price');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('material_suppliers', 'price')) {
            Schema::table('material_suppliers', function (Blueprint $table) {
                $table->decimal('price', 12, 2)->default(0)->after('supplier_id');
            });

            DB::table('material_supplier_prices')
                ->orderByDesc('id')
                ->get()
                ->groupBy('material_supplier_id')
                ->each(function ($prices, $materialSupplierId) {
                    DB::table('material_suppliers')
                        ->where('id', $materialSupplierId)
                        ->update(['price' => $prices->first()->price]);
                });
        }

        Schema::dropIfExists('material_supplier_prices');
    }
};
