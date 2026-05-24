<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('manufacturer_order_piece_progress');

        if (! Schema::hasTable('manufacturing_follow_up')) {
            Schema::create('manufacturing_follow_up', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('manufacturer_order_piece_id');
                $table->string('result');
                $table->text('details')->nullable();
                $table->decimal('quantity', 12, 4)->nullable();
                $table->integer('user_id')->nullable();
                $table->timestamps();

                $table->foreign('manufacturer_order_piece_id', 'mfu_assignment_fk')
                    ->references('id')
                    ->on('manufacturer_order_pieces')
                    ->cascadeOnDelete();
                $table->foreign('user_id', 'mfu_user_fk')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacturing_follow_up');

        if (! Schema::hasTable('manufacturer_order_piece_progress')) {
            Schema::create('manufacturer_order_piece_progress', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('manufacturer_order_piece_id');
                $table->decimal('quantity', 12, 4);
                $table->string('status');
                $table->integer('user_id')->nullable();
                $table->timestamps();
            });
        }
    }
};
