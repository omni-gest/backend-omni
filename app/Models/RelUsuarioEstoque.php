<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelUsuarioEstoque extends Model
{
    use HasFactory;

    protected $table = 'rel_usuario_estoque';

    protected $fillable = [
        'id_estoque_rue',
        'id_user_rue'
    ];

    public static function getEstoqueByIdUsuario(Int $id_user){
        $estoque = RelUsuarioEstoque::where('id_user_rue', $id_user)
        ->join('tb_estoque as te', 'rel_usuario_estoque.id_estoque_rue', '=', 'te.id_estoque_est')
        ->select([
            'te.id_estoque_est',
            'te.id_empresa_est',
            'te.des_estoque_est',
            'te.id_centro_custo_est'
        ])
        ->orderBy('te.des_estoque_est', 'DESC')
        ->get();

        return $estoque->toArray();
    }

}
