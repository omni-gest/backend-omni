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
        Schema::create('tb_estoque_item', function (Blueprint $table) {
            $table->id('id_estoque_item_eti');
            $table->unsignedBigInteger('id_material_eti');
            $table->foreign('id_material_eti')
                ->references('id_material_mte')
                ->on('tb_material');
            $table->unsignedBigInteger('id_empresa_eti');
            $table->foreign('id_empresa_eti')
                ->references('id_empresa_emp')
                ->on('tb_empresa');
            $table->unsignedBigInteger('id_centro_custo_eti');
            $table->string('des_estoque_item_eti')->nullable();
            $table->foreign('id_centro_custo_eti')
                ->references('id_centro_custo_cco')
                ->on('tb_centro_custo');
            $table->float('qtd_estoque_item_eti');
            $table->boolean('is_ativo_eti')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_estoque_item');
    }
};
