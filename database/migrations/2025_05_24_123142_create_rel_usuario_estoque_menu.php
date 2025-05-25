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
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 37,
            'des_menu_mnu' => 'Permissões de Estoque',
            'icon_menu_mnu' => 'GridFour',
            'path_menu_mnu' => '/cadastro-base/permissoes/permissoes-estoque',
            'num_ordem_mnu' => 38,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
