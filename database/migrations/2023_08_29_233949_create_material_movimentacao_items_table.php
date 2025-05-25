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
        Schema::create('tb_material_movimentacao_item', function (Blueprint $table) {
            $table->id('id_movimentacao_item_mit');
            $table->unsignedBigInteger('id_movimentacao_mit');
            $table->unsignedBigInteger('id_material_mit');
            $table->integer('qtd_material_mit');
            $table->boolean('is_ativo_mit')->default(true);
            $table->foreign('id_movimentacao_mit')->references('id_movimentacao_mov')->on('tb_material_movimentacao');
            $table->foreign('id_material_mit')->references('id_material_mte')->on('tb_material');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_material_movimentacao_item');
    }
};
