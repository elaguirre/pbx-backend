<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 15)->nullable();
            $table->boolean('has_2fa_enabled')->default(false);
            $table->string('timezone')->default('America/Chihuahua');
            $table->string('password_digest')->nullable();
            $table->string('password', 60)->nullable();
            $table->decimal('warehouse', 10)->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('active')->nullable();
            $table->boolean('deleted')->default(false);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->timestamp('password_updated_at')->nullable();
            $table->rememberToken();
            $table->integer('profile')->nullable();
            $table->boolean('open_casher')->default(false);
            $table->integer('cash_closing_id')->default(0);
            $table->boolean('can_unlock_seats')->nullable()->default(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
