<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPagamento extends Model
{
    use HasFactory;

    protected $table = "tb_metodo_pagamento";

    protected $fillable = [
        'desc_metodo_pagamento_tmp',
        'id_empresa_tmp'
    ];

    public static function getAll($id_empresa, $filter, $perPage = 10, $pageNumber = 1)
    {
        $paginator = MetodoPagamento::select(['*'])
        ->where('is_ativo_tmp', 1)
        ->where('desc_metodo_pagamento_tmp', 'like', '%'.$filter.'%')
        ->where('id_empresa_tmp', $id_empresa)
        ->orderBy('id_metodo_pagamento_tmp', 'desc')
        ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id_empresa, Int $id = null) {
        if($id) {
            $data = MetodoPagamento::select(['*'])
            ->where('id_metodo_pagamento_tmp', $id)
            ->where('is_ativo_tmp', 1)
            ->where('id_empresa_tmp', $id_empresa)
            ->orderBy('id_metodo_pagamento_tmp', 'desc')->get();
        }else{
            $data = MetodoPagamento::select(['*'])
            ->where('is_ativo_tmp', 1)
            ->orderBy('id_metodo_pagamento_tmp', 'desc')
            ->where('id_empresa_tmp', $id_empresa)
            ->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_empresa, Int $id_metodo_pagamento, $obj)
    {
        MetodoPagamento::
        where('id_metodo_pagamento_tmp', $id_metodo_pagamento)
        ->where('id_empresa_tmp', $id_empresa)
            ->update([
                'desc_metodo_pagamento_tmp' => $obj->desc_metodo_pagamento_tmp
            ]);
    }

    public static function deleteReg($id_empresa, $id_metodo_pagamento)
    {
        MetodoPagamento::
        where('id_metodo_pagamento_tmp', $id_metodo_pagamento)
        ->where('id_empresa_tmp', $id_empresa)
            ->update([
                'is_ativo_tmp' => 0
            ]);
    }
}
