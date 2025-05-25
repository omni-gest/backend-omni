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
        Schema::table('tb_fornecedor', function (Blueprint $table) {
            $table->renameColumn('id_empresa_Frn', 'id_empresa_frn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_fornecedor', function (Blueprint $table) {
            $table->renameColumn('id_empresa_frn', 'id_empresa_Frn');
        });
    }
};

