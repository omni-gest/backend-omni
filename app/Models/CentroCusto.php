<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCusto extends Model
{
    use HasFactory;

    protected $table = "tb_centro_custo";

    protected $primaryKey = 'id_centro_custo_cco';

    protected $fillable = [
        'des_centro_custo_cco',
        'is_ativo_cco',
        'id_empresa_cco',
    ];

    public static function getAll($id_usuario, $filter, $perPage = 10, $pageNumber = 1, $id_empresa, $getByCompany = false) {
        $query = CentroCusto::select('tb_centro_custo.*')
                ->where('tb_centro_custo.id_empresa_cco', $id_empresa);

        if (!$getByCompany) {
          $query->join('rel_usuario_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'rel_usuario_centro_custo.id_centro_custo_ccu')
                ->where('rel_usuario_centro_custo.id_user', $id_usuario);
        }

        $query->where('tb_centro_custo.is_ativo_cco', 1)
            ->where('tb_centro_custo.des_centro_custo_cco', 'like', '%' . $filter . '%')
            ->orderBy('tb_centro_custo.id_centro_custo_cco', 'desc');

        $paginator = $query->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id_usuario, Int $id_centro_custo) {
        $data = CentroCusto::select('tb_centro_custo.*')
            ->join('rel_usuario_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'rel_usuario_centro_custo.id_centro_custo_ccu')
            ->where('rel_usuario_centro_custo.id_user', $id_usuario)
            ->where('tb_centro_custo.id_centro_custo_cco', $id_centro_custo)
            ->where('tb_centro_custo.is_ativo_cco', 1)
            ->orderBy('tb_centro_custo.id_centro_custo_cco', 'desc')
            ->get();

        return response()
        ->json($data);
    }

    public static function updateReg(Int $id_empresa, Int $id_centro_custo, $obj) {
        CentroCusto::
        where('id_centro_custo_cco', $id_centro_custo)
        ->where('id_empresa_cco', $id_empresa)
        ->update([
            'des_centro_custo_cco' => $obj->des_centro_custo_cco
        ]);
    }

    public static function deleteReg($id_empresa, $id_cliente) {
        CentroCusto::
        where('id_centro_custo_cco', $id_cliente)
        ->where('id_empresa_cco', $id_empresa)
        ->update([
            'is_ativo_cco' => 0
        ]);
    }

}
