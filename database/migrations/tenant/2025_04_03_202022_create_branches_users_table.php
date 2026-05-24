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
        Schema::create('branches_users', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('branch_id');

            $table->index(['user_id', 'branch_id'], 'index_branches_users_on_user_id_and_branch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches_users');
    }
};
