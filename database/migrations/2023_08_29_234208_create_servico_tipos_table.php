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
        Schema::create('tb_servico_tipo', function (Blueprint $table) {
            $table->id('id_servico_tipo_stp');
            $table->string('des_servico_tipo_stp');
            $table->integer('vlr_servico_tipo_stp');
            $table->boolean('is_ativo_stp')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_servico_tipo');
    }
};
