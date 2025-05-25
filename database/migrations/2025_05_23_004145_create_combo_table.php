<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_combo', function (Blueprint $table){
            $table->id('id_combo_cmb');
            $table->string('desc_combo_cmb');
            $table->unsignedBigInteger('id_empresa_cmb');
            $table->unsignedBigInteger('id_centro_custo_cmb');
            $table->foreign('id_empresa_cmb')->references('id_empresa_emp')->on('tb_empresa');
            $table->foreign('id_centro_custo_cmb')->references('id_centro_custo_cco')->on('tb_centro_custo');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_combo');
    }
};
