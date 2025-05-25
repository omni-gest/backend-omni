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
        Schema::create('rel_usuario_menu', function (Blueprint $table) {
            $table->id('id_rel_usuario_menu_usm');
            $table->unsignedBigInteger('id_menu_usm');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_menu_usm')->references('id_menu_mnu')->on('tb_menu');
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_usuario_menu');
    }
};
