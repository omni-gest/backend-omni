<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tb_financeiro', function (Blueprint $table) {
            $table->id('id_financeiro_fin');
            $table->string('desc_financeiro_fin');
            $table->integer('vlr_financeiro_fin');
            $table->integer('tipo_transacao_fin');
            $table->unsignedBigInteger('id_empresa_fin');
            $table->unsignedBigInteger('id_centro_custo_fin');
            $table->unsignedBigInteger('id_referencia_fin')->nullable();
            $table->integer('tipo_referencia_fin');
            $table->timestamps();
            $table->foreign('id_empresa_fin')->references('id_empresa_emp')->on('tb_empresa');
            $table->foreign('id_centro_custo_fin')->references('id_centro_custo_cco')->on('tb_centro_custo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_financeiro');
    }
};

