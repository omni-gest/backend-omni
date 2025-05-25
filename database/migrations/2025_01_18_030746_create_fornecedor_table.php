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
        Schema::create('tb_fornecedor', function (Blueprint $table) {
            $table->id('id_fornecedor_frn');
            $table->string('desc_fornecedor_frn');
            $table->string('tel_fornecedor_frn', length:11);
            $table->string('documento_fornecedor_frn', length:14)->nullable();
            $table->boolean('is_ativo_frn')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_fornecedor');
    }
};
