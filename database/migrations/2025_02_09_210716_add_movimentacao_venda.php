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
        Schema::table('tb_venda', function (Blueprint $table) {
            $table->unsignedBigInteger('id_movimentacao_vda')->nullable();
            $table->foreign('id_movimentacao_vda')
            ->references('id_movimentacao_mov')
            ->on('tb_material_movimentacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_venda', function (Blueprint $table) {
            $table->dropForeign(['id_movimentacao_vda']);
            $table->dropColumn('id_movimentacao_vda');
        });
    }
};
