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

    public static function updateReg(Int $id_empresa, Int $id_combo_cmb, $obj){
        Combo::where('id_combo_cmb', $id_combo_cmb)
        ->where('id_empresa_cmb', $id_empresa)
        ->update([
            'desc_combo_cmb'       => $obj->desc_combo_cmb,
            'id_centro_custo_cmb'  => $obj->id_centro_custo_cmb,
        ]);
    }


}