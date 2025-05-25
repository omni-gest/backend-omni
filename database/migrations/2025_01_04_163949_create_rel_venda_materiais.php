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
        Schema::create('rel_venda_material', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_material_rvm");
            $table->unsignedBigInteger("id_venda_rvm");
            $table->integer('vlr_unit_material_rvm');
            $table->integer('qtd_material_rvm');
            $table->foreign("id_venda_rvm")->references("id_venda_vda")->on("tb_venda");
            $table->foreign("id_material_rvm")->references("id_material_mte")->on("tb_material");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_venda_materiais');
    }
};
