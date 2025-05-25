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
            $table->unsignedBigInteger('id_cliente_vda')->nullable();

            $table->foreign('id_cliente_vda')
                  ->references('id_cliente_cli')
                  ->on('tb_cliente')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_venda', function (Blueprint $table) {
            $table->dropForeign(['id_cliente_vda']);
            $table->dropColumn('id_cliente_vda');
        });
    }
};
