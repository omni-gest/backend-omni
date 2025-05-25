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
        Schema::create('rel_funcionarios_tipo_servico', function (Blueprint $table) {
            $table->id('id_rel_rft');
            $table->unsignedBigInteger('id_funcionario_rft');
            $table->unsignedBigInteger('id_tipo_servico_rft');
            $table->foreign('id_funcionario_rft')->references('id_funcionario_tfu')->on('tb_funcionarios');
            $table->foreign('id_tipo_servico_rft')->references('id_servico_tipo_stp')->on('tb_servico_tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_funcionarios_tipo_servico');
    }
};
