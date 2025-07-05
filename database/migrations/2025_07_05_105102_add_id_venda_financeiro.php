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
        Schema::table('tb_financeiro', function (Blueprint $table) {
            $table->unsignedBigInteger('id_venda_fin')->nullable()->after('id_financeiro_fin');
            $table->foreign('id_venda_fin')->references('id_venda_vda')->on('tb_venda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_financeiro', function (Blueprint $table) {
            $table->dropForeign(['id_venda_fin']);
            $table->dropColumn('id_venda_fin');
                    });
    }
};
