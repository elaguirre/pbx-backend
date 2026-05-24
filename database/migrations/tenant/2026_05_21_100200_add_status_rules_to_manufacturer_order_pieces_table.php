<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('manufacturer_order_pieces', 'available_status_id')) {
            Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
                $table->unsignedBigInteger('available_status_id')->nullable()->after('status');
                $table->unsignedBigInteger('piece_status_after_completion_id')->nullable()->after('available_status_id');
            });
        }

        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            if (! $this->foreignKeyExists('mop_available_status_fk')) {
                $table->foreign('available_status_id', 'mop_available_status_fk')
                    ->references('id')
                    ->on('order_piece_statuses')
                    ->restrictOnDelete();
            }

            if (! $this->foreignKeyExists('mop_after_completion_status_fk')) {
                $table->foreign('piece_status_after_completion_id', 'mop_after_completion_status_fk')
                    ->references('id')
                    ->on('order_piece_statuses')
                    ->restrictOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            if ($this->foreignKeyExists('mop_after_completion_status_fk')) {
                $table->dropForeign('mop_after_completion_status_fk');
            }

            if ($this->foreignKeyExists('mop_available_status_fk')) {
                $table->dropForeign('mop_available_status_fk');
            }

            if (Schema::hasColumn('manufacturer_order_pieces', 'piece_status_after_completion_id')) {
                $table->dropColumn(['piece_status_after_completion_id', 'available_status_id']);
            }
        });
    }

    private function foreignKeyExists(string $name): bool
    {
        $foreignKeys = Schema::getConnection()
            ->getSchemaBuilder()
            ->getForeignKeys('manufacturer_order_pieces');

        foreach ($foreignKeys as $foreignKey) {
            if ($foreignKey['name'] === $name) {
                return true;
            }
        }

        return false;
    }
};
