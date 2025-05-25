<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituicaoPagamento extends Model
{
    use HasFactory;

    protected $table = "tb_instituicao_pagamento";

    protected $fillable = [
        'desc_instituicao_pagamento_tip',
        'is_ativo_tip',
        'id_empresa_tip'
    ];

    public static function getAll($id_empresa, $filter, $perPage = 10, $pageNumber = 1)
    {
        $paginator = InstituicaoPagamento::
        select(['*'])
        ->where('is_ativo_tip', 1)
        ->where('desc_instituicao_pagamento_tip', 'like', '%'.$filter.'%')
        ->where('id_empresa_tip', $id_empresa)
        ->orderBy('id_instituicao_pagamento_tip', 'desc')
        ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id_empresa, Int $id = null) {
        if($id) {
            $data = InstituicaoPagamento::
            select(['*'])
            ->where('desc_instituicao_pagamento_tip', $id)
            ->where('is_ativo_tip', 1)
            ->where('id_empresa_tip', $id_empresa)
            ->orderBy('id_instituicao_pagamento_tip', 'desc')
            ->get();
        }else{
            $data = InstituicaoPagamento::
            select(['*'])
            ->where('is_ativo_tip', 1)
            ->orderBy('id_instituicao_pagamento_tip', 'desc')
            ->where('id_empresa_tip', $id_empresa)
            ->get();
        }
        return response()->json($data);
    }

    public static function updateReg(Int $id_empresa, Int $id_instituicao_pagamento, $obj)
    {
        InstituicaoPagamento::
        where('id_instituicao_pagamento_tip', $id_instituicao_pagamento)
        ->where('id_empresa_tip', $id_empresa)
            ->update([
                'desc_instituicao_pagamento_tip' => $obj->desc_instituicao_pagamento_tip
            ]);
    }

    public static function deleteReg($id_empresa, $id_instituicao_pagamento)
    {
        InstituicaoPagamento::
        where('id_instituicao_pagamento_tip', $id_instituicao_pagamento)
        ->where('id_empresa_tip', $id_empresa)
            ->update([
                'is_ativo_tip' => 0
            ]);
    }
}
