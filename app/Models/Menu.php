<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'tb_menu';

    protected $fillable = [];

    public static function getAll()
    {
        $data = Menu::select(['id_menu_mnu', 'id_father_mnu', 'des_menu_mnu', 'icon_menu_mnu', 'path_menu_mnu'])->orderby('num_ordem_mnu', 'DESC')->get();

        $arr = $data->toArray();
        $map = array_column($arr, null, 'id_menu_mnu');

        foreach ($arr as &$item) {
            if ($item['id_father_mnu'] !== null) {
                $map[$item['id_father_mnu']]['children'][] = $map[$item['id_menu_mnu']];
                unset($map[$item['id_menu_mnu']]);
            }
        }
        $map = array_reverse($map);
        $map = Menu::revertMenuChildren($map);
        return $map;
    }

    private static function revertMenuChildren($arr)
    {
        foreach ($arr as &$item) {
            if (isset($item['children'])) {
                $item['children'] = array_reverse($item['children']);
                $item['children'] = Menu::revertMenuChildren($item['children']);
            }
        }

        return $arr;
    }
}
