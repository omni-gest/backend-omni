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
        Schema::create('tb_estoque', function (Blueprint $table) {
            $table->id('id_estoque_est');
            $table->string('des_estoque_est', 255);
            $table->unsignedBigInteger('id_centro_custo_est');
            $table->boolean('is_ativo_est')->default(true);
            $table->foreign('id_centro_custo_est')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_estoque');
    }
};
