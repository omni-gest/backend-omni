<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tb_financeiro', function (Blueprint $table) {
            $table->unsignedBigInteger('id_metodo_pagamento_fin')->nullable()->after('tipo_referencia_fin');
            $table->foreign('id_metodo_pagamento_fin')
                  ->references('id_metodo_pagamento_tmp')
                  ->on('tb_metodo_pagamento');
        });
    }

    public function down(): void
    {
        Schema::table('tb_financeiro', function (Blueprint $table) {
            $table->dropForeign(['id_metodo_pagamento_fin']);
            $table->dropColumn('id_metodo_pagamento_fin');
        });
    }
};
