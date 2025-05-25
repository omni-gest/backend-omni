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
        Schema::table('tb_material_movimentacao_item', function (Blueprint $table) {
            $table->string('tipo_movimentacao_mit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_material_movimentacao_item', function (Blueprint $table) {
            // Reverte as alterações
            $table->dropColumn('tipo_movimentacao_mit');
        });
    }
};
