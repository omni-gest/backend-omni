<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RelUsuarioMenu extends Model
{
    use HasFactory;

    protected $table = 'rel_usuario_menu';

    protected $fillable = [
        'id_menu_usm',
        'id_user'
    ];

    public static function getMenuByIdUsuario(Int $id_user){
        $menus = RelUsuarioMenu::where('id_user', $id_user)
        ->join('tb_menu as tm', 'rel_usuario_menu.id_menu_usm', '=', 'tm.id_menu_mnu')
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
        $map = RelUsuarioMenu::revertMenuChildren($map);
        return $map;
    }

    private static function revertMenuChildren($arr)
    {
        foreach ($arr as &$item) {
            if (isset($item['children'])) {
                $item['children'] = array_reverse($item['children']);
                $item['children'] = RelUsuarioMenu::revertMenuChildren($item['children']);
            }
        }

        return $arr;
    }
}
