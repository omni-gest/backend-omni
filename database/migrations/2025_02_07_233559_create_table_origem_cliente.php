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
        Schema::create('tb_origem_cliente', function (Blueprint $table) {
            $table->id('id_origem_cliente_orc');
            $table->string('desc_origem_cliente_orc', length:40)->nullable();
            $table->boolean('is_ativo_orc')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_origem_cliente');
    }
};
