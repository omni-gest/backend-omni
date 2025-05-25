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
        Schema::create('tb_venda', function (Blueprint $table) {
            $table->id("id_venda_vda");
            $table->unsignedBigInteger('id_funcionario_vda');
            $table->unsignedBigInteger('id_centro_custo_vda');
            $table->string('desc_venda_vda')->nullable();
            $table->foreign("id_funcionario_vda")->references("id_funcionario_tfu")->on("tb_funcionarios");
            $table->foreign("id_centro_custo_vda")->references("id_centro_custo_cco")->on("tb_centro_custo");
            $table->boolean("is_deleted")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_venda');
    }
};
