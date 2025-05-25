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
        Schema::create('tb_conta_tipo', function (Blueprint $table) {
            $table->id('id_conta_tipo_ctp');
            $table->string('des_conta_tipo_ctp');
            $table->boolean('is_ativo_ctp')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_conta_tipo');
    }
};
