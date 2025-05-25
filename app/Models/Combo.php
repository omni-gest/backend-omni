<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    protected $table = "tb_combo";
    protected $primaryKey = 'id_combo_cmb';
    protected $fillable = [
        'desc_combo_cmb',
        'id_empresa_cmb',
        'id_centro_custo_cmb',
    ];

    public static function getAll($id_empresa, $id_centro_custo)
    {
        $data = Combo::select('tb_combo.*')
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_combo.id_centro_custo_cmb')
        ->where('is_ativo_cmb', 1)
        ->where('id_empresa_cmb', $id_empresa)
        ->where('id_centro_custo_cmb', $id_centro_custo)
        ->orderBy('id_combo_cmb', 'desc')
        ->get();

        return response()->json($data);
    }

    public static function getById($id_empresa, $id_combo)
    {
        $data = Combo::select('tb_combo.*')
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_combo.id_centro_custo_cmb')
        ->where('is_ativo_cmb', 1)
        ->where('id_empresa_cmb', $id_empresa)
        ->where('id_combo_cmb', $id_combo)
        ->get();

        return response()->json($data);
    }

    public static function updateReg(Int $id_empresa, Int $id_combo_cmb, $obj){
        Combo::where('id_combo_cmb', $id_combo_cmb)
        ->where('id_empresa_cmb', $id_empresa)
        ->update([
            'desc_combo_cmb'       => $obj->desc_combo_cmb,
            'id_centro_custo_cmb'  => $obj->id_centro_custo_cmb,
        ]);
    }


}