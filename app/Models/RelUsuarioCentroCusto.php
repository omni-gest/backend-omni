<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelUsuarioCentroCusto extends Model
{
    use HasFactory;

    protected $table = "rel_usuario_centro_custo";

    protected $primaryKey = 'id_rel_usuario_centro_custo_ccu';

    protected $fillable = [
        'id_centro_custo_ccu',
        'id_user'
    ];

    public static function getCentroCustoByIdUsuario(Int $id_user){
        $centroCustoList = RelUsuarioCentroCusto::where('id_user', $id_user)
        ->join('tb_centro_custo as tcc', 'rel_usuario_centro_custo.id_centro_custo_ccu', '=', 'tcc.id_centro_custo_cco')
        ->select([
            'id_centro_custo_cco','des_centro_custo_cco'
        ])
        ->orderby('id_centro_custo_cco', 'DESC')
        ->get();

        return $centroCustoList;
    }

}