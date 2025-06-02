<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rel_venda_combo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_venda_rvc');
            $table->unsignedBigInteger('id_combo_rvc');
            $table->integer('qtd_combo_rvc');
            $table->timestamps();

            $table->foreign('id_venda_rvc')->references('id_venda_vda')->on('tb_venda')->onDelete('cascade');
            $table->foreign('id_combo_rvc')->references('id_combo_cmb')->on('tb_combo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_venda_combo');
    }
};
