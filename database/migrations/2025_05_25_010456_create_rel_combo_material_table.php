<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rel_combo_material', function (Blueprint $table) {
            $table->id('id_combo_material_cbm');
            $table->unsignedBigInteger('id_combo_cbm');
            $table->unsignedBigInteger('id_material_cbm');
            $table->timestamps();

            $table->foreign('id_combo_cbm')
                  ->references('id_combo_cmb')
                  ->on('tb_combo')
                  ->onDelete('cascade');

            $table->foreign('id_material_cbm')
                  ->references('id_material_mte')
                  ->on('tb_material')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rel_combo_material');
    }
};

