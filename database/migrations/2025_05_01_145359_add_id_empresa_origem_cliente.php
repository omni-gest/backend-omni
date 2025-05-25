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
        Schema::table('tb_origem_cliente', function (Blueprint $table) {
            $table->unsignedBigInteger('id_empresa_orc')->default(1);
        });

        Schema::table('tb_origem_cliente', function (Blueprint $table) {
            $table->foreign('id_empresa_orc', 'fk_origem_cliente_empresa')
                  ->references('id_empresa_emp')
                  ->on('tb_empresa')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_origem_cliente', function (Blueprint $table) {
            $table->dropForeign('fk_origem_cliente_empresa');
        });

        Schema::table('tb_origem_cliente', function (Blueprint $table) {
            $table->dropColumn('id_empresa_orc');
        });
    }
};
