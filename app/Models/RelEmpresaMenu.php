<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelEmpresaMenu extends Model
{
    use HasFactory;

    protected $table = 'rel_empresa_menu';

    protected $fillable = [
        'id_empresa_emn',
        'id_menu_emn'
    ];

    public static function getMenuByIdEmpresa(Int $id_empresa){
        $menus = RelEmpresaMenu::where('id_empresa_emn', $id_empresa)
        ->join('tb_menu as tm', 'rel_empresa_menu.id_menu_emn', '=', 'tm.id_menu_mnu')
        ->select([
           'id_menu_mnu', 'id_father_mnu', 'des_menu_mnu', 'icon_menu_mnu', 'path_menu_mnu'
        ])
        ->orderby('num_ordem_mnu', 'DESC')
        ->get();

        $arr = $menus->toArray();
        $map = array_column($arr, null, 'id_menu_mnu');

        foreach ($arr as &$item) {
            if ($item['id_father_mnu'] !== null) {
                $map[$item['id_father_mnu']]['children'][] = $map[$item['id_menu_mnu']];
                unset($map[$item['id_menu_mnu']]);
            }
        }
        $map = array_reverse($map);
        $map = RelEmpresaMenu::revertMenuChildren($map);
        return $map;
    }

    private static function revertMenuChildren($arr)
    {
        foreach ($arr as &$item) {
            if (isset($item['children'])) {
                $item['children'] = array_reverse($item['children']);
                $item['children'] = RelEmpresaMenu::revertMenuChildren($item['children']);
            }
        }

        return $arr;
    }
}
