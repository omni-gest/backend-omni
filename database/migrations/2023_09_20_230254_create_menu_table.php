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
        Schema::create('tb_menu', function (Blueprint $table) {
            $table->id('id_menu_mnu');
            $table->integer('id_father_mnu')->nullable();
            $table->string('des_menu_mnu');
            $table->string('icon_menu_mnu');
            $table->string('path_menu_mnu');
            $table->boolean('is_ativo_mnu')->default(true);
            $table->integer('num_ordem_mnu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_menu');
    }
};
