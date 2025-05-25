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
        Schema::create('tb_pessoa', function (Blueprint $table){
            $table->id('id_pessoa_pes');
            $table->unsignedBigInteger('id_centro_custo_pes');
            $table->string('nome_pessoa_pes', 100);
            $table->string('documento_pessoa_pes', 14);
            $table->boolean('is_ativo_pes')->default(true);
            $table->foreign('id_centro_custo_pes')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pessoa');
    }
};
