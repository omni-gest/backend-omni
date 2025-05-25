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
        Schema::create('tb_conta', function (Blueprint $table) {
            $table->id('id_conta_con');
            $table->date('dta_conta_con');
            $table->integer('vlr_conta_con');
            $table->unsignedBigInteger('id_centro_custo_con');
            $table->unsignedBigInteger('id_metodo_pagamento_con');
            $table->unsignedBigInteger('id_conta_tipo_con');
            $table->boolean('is_ativo_con')->default(true);
            $table->foreign('id_centro_custo_con')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->foreign('id_metodo_pagamento_con')->references('id_metodo_pagamento_tmp')->on('tb_metodo_pagamento');
            $table->foreign('id_conta_tipo_con')->references('id_conta_tipo_ctp')->on('tb_conta_tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_conta');
    }
};
