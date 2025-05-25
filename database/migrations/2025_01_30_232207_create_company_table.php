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
        Schema::create('tb_empresa', function (Blueprint $table) {
            $table->id('id_empresa_emp');
            $table->string('des_empresa_emp');
            $table->string('razao_social_empresa_emp');
            $table->string('cnpj_empresa_emp');
            $table->string('des_endereco_emp');
            $table->string('des_cidade_emp');
            $table->string('des_cep_emp');
            $table->string('des_tel_emp');
            $table->string('lnk_whatsapp_emp')->nullable();
            $table->string('lnk_instagram_emp')->nullable();
            $table->string('lnk_facebook_emp')->nullable();
            $table->string('img_empresa_emp')->nullable();
            $table->boolean('is_ativo_emp')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_empresa');
    }
};
