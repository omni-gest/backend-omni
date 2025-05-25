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
        Schema::create('tb_cliente', function (Blueprint $table) {
            $table->id('id_cliente_cli');
            $table->string('des_cliente_cli');
            $table->string('telefone_cliente_cli');
            $table->string('email_cliente_cli')->nullable();
            $table->string('documento_cliente_cli')->nullable();
            $table->string('endereco_cliente_cli')->nullable();
            $table->boolean('is_ativo_cli')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_cliente');
    }
};
