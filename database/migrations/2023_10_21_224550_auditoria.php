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
        Schema::create('tb_auditoria', function (Blueprint $table) {
            $table->id('id_auditoria_aud');
            $table->integer('id_externo_aud');
            $table->string('des_alteracao_aud', 20);
            $table->string('des_tabela_aud', 100);
            $table->string('json_original_aud', 1000)->nullable();
            $table->string('json_alteracao_aud', 1000);
            $table->timestamp('dth_cadastro_aud');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_auditoria');
    }
};
