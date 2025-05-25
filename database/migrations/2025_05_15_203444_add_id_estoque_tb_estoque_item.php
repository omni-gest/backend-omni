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
        Schema::table('tb_estoque_item', function (Blueprint $table) {
            $table->dropForeign(['id_centro_custo']);
            $table->dropColumn(['id_centro_custo']);
            $table->unsignedBigInteger('id_estoque_eti')->nullable();
            $table->foreign('id_estoque_eti')
                ->references('id_estoque_est')
                ->on('tb_estoque')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_estoque_item', function (Blueprint $table) {
            $table->unsignedBigInteger('id_centro_custo')->nullable()->after('id_estoque_eti');
            $table->foreign('id_centro_custo')
                ->references('id_centro_custo_cco')
                ->on('tb_centro_custo')
                ->onDelete('cascade');
            $table->dropForeign(['id_estoque_eti']);
            $table->dropColumn('id_estoque_eti');
        });
    }
};
