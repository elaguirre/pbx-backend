<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('manufacturer_order_piece_progress')) {
            Schema::create('manufacturer_order_piece_progress', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('manufacturer_order_piece_id');
                $table->decimal('quantity', 12, 4);
                $table->string('status');
                $table->integer('user_id')->nullable();
                $table->timestamps();
            });
        } elseif (Schema::hasColumn('manufacturer_order_piece_progress', 'user_id')) {
            Schema::table('manufacturer_order_piece_progress', function (Blueprint $table) {
                $table->integer('user_id')->nullable()->change();
            });
        }

        Schema::table('manufacturer_order_piece_progress', function (Blueprint $table) {
            if (! $this->foreignKeyExists('mopp_assignment_fk')) {
                $table->foreign('manufacturer_order_piece_id', 'mopp_assignment_fk')
                    ->references('id')
                    ->on('manufacturer_order_pieces')
                    ->cascadeOnDelete();
            }

            if (! $this->foreignKeyExists('mopp_user_fk')) {
                $table->foreign('user_id', 'mopp_user_fk')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('manufacturer_order_piece_progress', function (Blueprint $table) {
            if ($this->foreignKeyExists('mopp_user_fk')) {
                $table->dropForeign('mopp_user_fk');
            }

            if ($this->foreignKeyExists('mopp_assignment_fk')) {
                $table->dropForeign('mopp_assignment_fk');
            }
        });

        Schema::dropIfExists('manufacturer_order_piece_progress');
    }

    protected function foreignKeyExists(string $name): bool
    {
        return collect(Schema::getForeignKeys('manufacturer_order_piece_progress'))
            ->contains(fn (array $key) => $key['name'] === $name);
    }
};
