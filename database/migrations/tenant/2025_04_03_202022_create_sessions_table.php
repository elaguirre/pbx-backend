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
        Schema::create('sessions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('scope', 50)->nullable()->index();
            $table->unsignedBigInteger('device_id')->nullable()->index();
            $table->string('ip')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('workstation')->nullable();
            $table->dateTime('final_date')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('user_id')->nullable()->index('index_sessions_on_user_id');
            $table->string('token')->nullable()->unique();
            $table->integer('customer_id')->nullable()->index('index_sessions_on_customer_id');
            $table->unsignedBigInteger('login_attempts')->default(0);
            $table->boolean('verified_by_2fa')->default(false);

            $table->index(['token'], 'token_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
