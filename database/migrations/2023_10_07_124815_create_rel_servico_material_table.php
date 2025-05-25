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
        Schema::create('rel_servico_material', function (Blueprint $table) {
            $table->id('id_rel_rsm');
            $table->unsignedBigInteger('id_servico_rsm');
            $table->unsignedBigInteger('id_material_rsm');
            $table->integer('vlr_material_rsm');
            $table->integer('qtd_material_rsm');
            $table->foreign('id_servico_rsm')->references('id_servico_ser')->on('tb_servico');
            $table->foreign('id_material_rsm')->references('id_material_mte')->on('tb_material');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_servico_material');
    }
};
