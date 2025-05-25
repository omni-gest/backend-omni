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
        Schema::create('rel_servico_tipo_servico', function (Blueprint $table) {
            $table->id('id_rel_rst');
            $table->unsignedBigInteger('id_servico_rst');
            $table->unsignedBigInteger('id_tipo_servico_rst');
            $table->integer('vlr_tipo_servico_rst');
            $table->foreign('id_servico_rst')->references('id_servico_ser')->on('tb_servico');
            $table->foreign('id_tipo_servico_rst')->references('id_servico_tipo_stp')->on('tb_servico_tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_servico_tipo_servico');
    }
};
