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
        Schema::create('rel_usuario_centro_custo', function (Blueprint $table) {
            $table->id('id_rel_usuario_centro_custo_ccu');
            $table->unsignedBigInteger('id_centro_custo_ccu');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_centro_custo_ccu')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_usuario_centro_custo');
    }
};
