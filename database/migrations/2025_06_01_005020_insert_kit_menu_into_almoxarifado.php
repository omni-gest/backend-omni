<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $almoxarifadoId = DB::table('tb_menu')
            ->where('des_menu_mnu', 'Almoxarifado')
            ->whereNull('id_father_mnu')
            ->value('id_menu_mnu');

        if ($almoxarifadoId) {
            DB::table('tb_menu')->insert([
                'id_father_mnu' => $almoxarifadoId,
                'des_menu_mnu'  => 'Kit',
                'icon_menu_mnu' => 'DropboxLogo',
                'path_menu_mnu' => '/almoxarifado/kit',
                'num_ordem_mnu' => DB::table('tb_menu')
                    ->where('id_father_mnu', $almoxarifadoId)
                    ->max('num_ordem_mnu') + 1,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('tb_menu')
            ->where('des_menu_mnu', 'Kit')
            ->where('path_menu_mnu', '/almoxarifado/kit')
            ->delete();
    }
};

