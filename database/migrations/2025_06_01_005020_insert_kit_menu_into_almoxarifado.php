<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $almoxarifadoId = DB::table('tb_menu')
            ->where('des_menu_mnu', 'Almoxarifado')
            ->where('id_father_mnu', 15)
            ->value('id_menu_mnu');
        if ($almoxarifadoId) {
            DB::table('tb_menu')->insert([
                'id_father_mnu' => $almoxarifadoId,
                'des_menu_mnu'  => 'Kit de Material',
                'icon_menu_mnu' => 'DropboxLogo',
                'path_menu_mnu' => '/cadastro-base/almoxarifado/kit',
                'num_ordem_mnu' => DB::table('tb_menu')
                    ->where('id_father_mnu', $almoxarifadoId)
                    ->max('num_ordem_mnu') + 1,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('rel_empresa_menu')
            ->join('tb_menu', 'rel_empresa_menu.id_menu_emn', '=', 'tb_menu.id_menu_mnu')
            ->where('des_menu_mnu', 'Kit')
            ->where('path_menu_mnu', '/almoxarifado/kit')
            ->delete();
        DB::table('rel_usuario_menu')
            ->join('tb_menu', 'rel_usuario_menu.id_menu_usm', '=', 'tb_menu.id_menu_mnu')
            ->where('des_menu_mnu', 'Kit')
            ->where('path_menu_mnu', '/almoxarifado/kit')
            ->delete();
        DB::table('tb_menu')
            ->where('des_menu_mnu', 'Kit de Material')
            ->where('path_menu_mnu', '/almoxarifado/kit')
            ->delete();
    }
};

