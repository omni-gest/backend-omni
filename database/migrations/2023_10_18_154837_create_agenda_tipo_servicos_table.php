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
        Schema::create('rel_servico_agenda_tipo_servico', function (Blueprint $table) {
            $table->id('id_rel_rat');
            $table->unsignedBigInteger('id_agenda_rat');
            $table->unsignedBigInteger('id_tipo_servico_rat');
            $table->integer('vlr_tipo_servico_rat');
            $table->foreign('id_agenda_rat')->references('id_agenda_age')->on('tb_servico_agenda');
            $table->foreign('id_tipo_servico_rat')->references('id_servico_tipo_stp')->on('tb_servico_tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_servico_agenda_tipo_servico');
    }
};
