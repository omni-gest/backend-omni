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
        Schema::create('tb_unidade', function (Blueprint $table) {
            $table->id('id_unidade_und');
            $table->string('des_unidade_und');
            $table->string('des_reduz_unidade_und');
            $table->boolean('is_ativo_und')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_unidade');
    }
};
