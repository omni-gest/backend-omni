<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigemCliente extends Model
{
    use HasFactory;

    protected $table = "tb_origem_cliente";

    protected $primaryKey = 'id_origem_cliente_orc';

    protected $fillable = [
        'desc_origem_cliente_orc',
        'id_origem_cliente_orc',
        'is_ativo_orc'
    ];

    public static function getAll($filter, $perPage = 10, $pageNumber = 1) {
        $paginator = OrigemCliente::
            select(['*'])
            ->where('is_ativo_orc', 1)
            ->where('desc_origem_cliente_orc', 'like', '%'.$filter.'%')
            ->orderBy('id_origem_cliente_orc', 'desc')
            ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id_origem_cliente_orc) {

        $data = OrigemCliente::select(['*'])
        ->where('id_origem_cliente_orc', $id_origem_cliente_orc)
        ->where('is_ativo_orc', 1)
        ->first();
        
        return $data;
    }

    public static function updateReg(int $id_origem_cliente_orc, $dados_atualizados) {
        OrigemCliente::
        where('id_origem_cliente_orc', $id_origem_cliente_orc)
        ->update([
            'desc_origem_cliente_orc' => $dados_atualizados['desc_origem_cliente_orc']
        ]);
    }

    public static function deleteReg($id_origem_cliente_orc) {
        OrigemCliente::
        where('id_origem_cliente_orc', $id_origem_cliente_orc)
        ->update([
            'is_ativo_orc' => 0
        ]);
    }

}
