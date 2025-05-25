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
        Schema::create('tb_funcionarios', function (Blueprint $table) {
            $table->id('id_funcionario_tfu');
            $table->unsignedBigInteger('id_funcionario_cargo_tfu');
            $table->string('desc_funcionario_tfu');
            $table->string('telefone_funcionario_tfu');
            $table->string('documento_funcionario_tfu');
            $table->string('endereco_funcionario_tfu');
            $table->boolean('is_ativo_tfu')->default(true);
            $table->foreign('id_funcionario_cargo_tfu')->references('id_cargo_tcg')->on('tb_cargos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_funcionarios');
    }
};
