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
        Schema::table('tb_servico_tipo', function (Blueprint $table) {
            $table->unsignedBigInteger('id_centro_custo_stp')->nullable();

            $table->foreign('id_centro_custo_stp')
                  ->references('id_centro_custo_cco')
                  ->on('tb_centro_custo')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_servico_tipo', function (Blueprint $table) {
            $table->dropForeign(['id_centro_custo_stp']);
            $table->dropColumn('id_centro_custo_stp');
        });
    }
};
