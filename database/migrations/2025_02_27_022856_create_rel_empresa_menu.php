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
        Schema::create('rel_empresa_menu', function (Blueprint $table) {
            $table->id('id_rel_empresa_menu_emn');
            $table->unsignedBigInteger('id_empresa_emn');
            $table->unsignedBigInteger('id_menu_emn');
            $table->foreign('id_empresa_emn')->references('id_empresa_emp')->on('tb_empresa');
            $table->foreign('id_menu_emn')->references('id_menu_mnu')->on('tb_menu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_empresa_menu');
    }
};

