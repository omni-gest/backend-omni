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
        Schema::create('tb_centro_custo', function (Blueprint $table) {
            $table->id('id_centro_custo_cco');
            $table->string('des_centro_custo_cco');
            $table->boolean('is_ativo_cco')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_centro_custo');
    }
};
