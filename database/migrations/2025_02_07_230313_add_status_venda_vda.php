<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_venda', function (Blueprint $table){
            $table->unsignedBigInteger('id_status_vda');
            $table->foreign('id_status_vda')
            ->references('id_status_sts')
            ->on('tb_status')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_venda', function (Blueprint $table){
            $table->dropForeign(['id_status_vda']);
            $table->dropColumn('id_status_vda');
        });
    }
};
