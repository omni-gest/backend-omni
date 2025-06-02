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
        Schema::table('rel_combo_material', function (Blueprint $table) {
            $table->integer('qtd_material_cbm')->after('id_material_cbm');
        });
        Schema::table('tb_combo', function (Blueprint $table) {
            $table->integer('vlr_combo_cmb')->after('id_empresa_cmb');
        });
    }
    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('rel_combo_material', function (Blueprint $table) {
            $table->dropColumn('qtd_material_cbm');
        });
        Schema::table('tb_combo', function (Blueprint $table) {
            $table->dropColumn('vlr_combo_cmb');
        });
    }
};
