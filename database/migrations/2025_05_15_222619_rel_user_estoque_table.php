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
        Schema::create('rel_user_estoque', function (Blueprint $table) {
            $table->id('id_user_estoque_rue');
            $table->unsignedBigInteger('id_estoque_rue');
            $table->unsignedBigInteger('id_user_rue');
            $table->foreign('id_estoque_rue')->references('id_estoque_est')->on('tb_estoque');
            $table->foreign('id_user_rue')->references('id')->on('users');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_user_estoque');
    }
};
