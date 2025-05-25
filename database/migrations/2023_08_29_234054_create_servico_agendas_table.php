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
        Schema::create('tb_servico_agenda', function (Blueprint $table) {
            $table->id('id_agenda_age');
            $table->dateTime('dth_agenda_age');
            $table->longText('txt_agenda_age')->nullable();
            
            $table->unsignedBigInteger('id_funcionario_age');
            $table->foreign('id_funcionario_age')->references('id_funcionario_tfu')->on('tb_funcionarios');

            $table->unsignedBigInteger('id_cliente_age')->nullable();
            $table->foreign('id_cliente_age')->references('id_cliente_cli')->on('tb_cliente');

            $table->unsignedBigInteger('id_servico_age')->nullable();
            $table->foreign('id_servico_age')->references('id_servico_ser')->on('tb_servico');

            
            $table->unsignedBigInteger('id_situacao_age')->default(10);
            // 10 - Pre agendado
            // 11 - Agendado (Cria serviço)
            // 12 - Cancelado
            $table->foreign('id_situacao_age')->references('id_situacao_tsi')->on('tb_situacao');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_servico_agenda');
    }
};
