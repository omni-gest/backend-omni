<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_venda', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estoque_vda')->nullable()->after('id_centro_custo_vda');
            $table->foreign('id_estoque_vda')->references('id_estoque_est')->on('tb_estoque');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_venda', function (Blueprint $table) {
            $table->dropForeign(['id_estoque_vda']);
            $table->dropColumn('id_estoque_vda');
        });
    }
};
