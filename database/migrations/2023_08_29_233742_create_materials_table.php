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
        Schema::create('tb_material', function (Blueprint $table) {
            $table->id('id_material_mte');
            $table->unsignedBigInteger('id_unidade_mte');
            $table->string('des_material_mte', 255);
            $table->float('vlr_material_mte');
            $table->boolean('is_ativo_mte')->default(true);
            $table->foreign('id_unidade_mte')->references('id_unidade_und')->on('tb_unidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_material');
    }
};
