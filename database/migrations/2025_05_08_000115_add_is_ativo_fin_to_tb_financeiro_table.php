<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tb_financeiro', function (Blueprint $table) {
            $table->boolean('is_ativo_fin')->default(1)->after('tipo_referencia_fin');
        });
    }

    public function down(): void
    {
        Schema::table('tb_financeiro', function (Blueprint $table) {
            $table->dropColumn('is_ativo_fin');
        });
    }
};
