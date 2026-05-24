<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('manufacturer_order_pieces', 'status_of_completed_pieces')) {
            return;
        }

        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            $table->unsignedBigInteger('status_of_completed_pieces')->nullable()->after('available_status_id');
        });

        if (Schema::hasColumn('manufacturer_order_pieces', 'piece_status_after_completion_id')) {
            DB::table('manufacturer_order_pieces')
                ->whereNotNull('piece_status_after_completion_id')
                ->update([
                    'status_of_completed_pieces' => DB::raw('piece_status_after_completion_id'),
                ]);
        }

        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            if ($this->foreignKeyExists('mop_after_completion_status_fk')) {
                $table->dropForeign('mop_after_completion_status_fk');
            }

            if (Schema::hasColumn('manufacturer_order_pieces', 'piece_status_after_completion_id')) {
                $table->dropColumn('piece_status_after_completion_id');
            }

            if (! $this->foreignKeyExists('mop_completed_pieces_status_fk')) {
                $table->foreign('status_of_completed_pieces', 'mop_completed_pieces_status_fk')
                    ->references('id')
                    ->on('order_piece_statuses')
                    ->restrictOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('manufacturer_order_pieces', 'status_of_completed_pieces')) {
            return;
        }

        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            if (! Schema::hasColumn('manufacturer_order_pieces', 'piece_status_after_completion_id')) {
                $table->unsignedBigInteger('piece_status_after_completion_id')->nullable()->after('available_status_id');
            }
        });

        DB::table('manufacturer_order_pieces')
            ->whereNotNull('status_of_completed_pieces')
            ->update([
                'piece_status_after_completion_id' => DB::raw('status_of_completed_pieces'),
            ]);

        Schema::table('manufacturer_order_pieces', function (Blueprint $table) {
            if ($this->foreignKeyExists('mop_completed_pieces_status_fk')) {
                $table->dropForeign('mop_completed_pieces_status_fk');
            }

            if (Schema::hasColumn('manufacturer_order_pieces', 'status_of_completed_pieces')) {
                $table->dropColumn('status_of_completed_pieces');
            }

            if (! $this->foreignKeyExists('mop_after_completion_status_fk')) {
                $table->foreign('piece_status_after_completion_id', 'mop_after_completion_status_fk')
                    ->references('id')
                    ->on('order_piece_statuses')
                    ->restrictOnDelete();
            }
        });
    }

    protected function foreignKeyExists(string $name): bool
    {
        return collect(Schema::getForeignKeys('manufacturer_order_pieces'))
            ->contains(fn (array $key) => $key['name'] === $name);
    }
};
