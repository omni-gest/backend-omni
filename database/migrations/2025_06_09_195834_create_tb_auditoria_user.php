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
        Schema::create('tb_auditoria_user', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->unsignedBigInteger('registro_id');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->string('evento');
            $table->json('valores_anteriores')->nullable();
            $table->json('valores_novos')->nullable();
            $table->string('url')->nullable();
            $table->string('rota')->nullable();
            $table->string('metodo', 10)->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_auditoria_user');
    }
};
