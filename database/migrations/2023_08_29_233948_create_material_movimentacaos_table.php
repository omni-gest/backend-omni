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
        Schema::create('tb_material_movimentacao', function (Blueprint $table) {
            $table->id('id_movimentacao_mov');
            $table->longText('txt_movimentacao_mov')->nullable();
            $table->unsignedBigInteger('id_centro_custo_mov');
            $table->unsignedBigInteger('id_estoque_entrada_mov')->nullable();
            $table->unsignedBigInteger('id_estoque_saida_mov')->nullable();
            $table->boolean('is_ativo_mov')->default(true);
            $table->foreign('id_centro_custo_mov')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->foreign('id_estoque_entrada_mov')->references('id_estoque_est')->on('tb_estoque');
            $table->foreign('id_estoque_saida_mov')->references('id_estoque_est')->on('tb_estoque');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_material_movimentacao');
    }
};
