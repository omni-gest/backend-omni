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
        Schema::create('tb_servico', function (Blueprint $table) {
            $table->id('id_servico_ser');
            $table->longText('txt_servico_ser')->nullable();
            $table->integer('vlr_servico_ser')->nullable();
            $table->dateTime('dta_agendamento_ser')->nullable();
            $table->unsignedBigInteger('id_situacao_ser')->default(1);
            $table->unsignedBigInteger('id_funcionario_servico_ser');
            $table->unsignedBigInteger('id_centro_custo_ser');
            $table->unsignedBigInteger('id_cliente_ser');
            $table->foreign('id_cliente_ser')->references('id_cliente_cli')->on('tb_cliente');
            $table->foreign('id_centro_custo_ser')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->foreign('id_situacao_ser')->references('id_situacao_tsi')->on('tb_situacao');
            $table->foreign('id_funcionario_servico_ser')->references('id_funcionario_tfu')->on('tb_funcionarios');
            $table->boolean('is_ativo_ser')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_servico');
    }
};
