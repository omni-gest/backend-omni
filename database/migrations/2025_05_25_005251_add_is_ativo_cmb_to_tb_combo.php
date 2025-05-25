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
        Schema::table('tb_combo', function (Blueprint $table) {
            $table->boolean('is_ativo_cmb')->after('id_centro_custo_cmb')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_combo', function (Blueprint $table) {
            $table->dropColumn('is_ativo_cmb');
        });
    }
};
