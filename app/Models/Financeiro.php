<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    use HasFactory;

    protected $table = "tb_financeiro";

    protected $primaryKey = 'id_financeiro_fin';

    protected $fillable = [
        'desc_financeiro_fin',
        'vlr_financeiro_fin',
        'tipo_transacao_fin',
        'id_empresa_fin',
        'id_referencia_fin',
        'tipo_referencia_fin',
        'id_centro_custo_fin',
        'id_metodo_pagamento_fin',
        'is_ativo_fin',
    ];

    public static function getAll($id_empresa, $filter, $perPage = 10, $pageNumber = 1, $type = null)
    {
        $paginator = Financeiro::select('tb_financeiro.*', 'tb_centro_custo.des_centro_custo_cco','tb_metodo_pagamento.desc_metodo_pagamento_tmp')
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_financeiro.id_centro_custo_fin')
        ->join('tb_metodo_pagamento', 'tb_metodo_pagamento.id_metodo_pagamento_tmp', '=', 'tb_financeiro.id_metodo_pagamento_fin')
        ->where('is_ativo_fin', 1)
        ->where('desc_financeiro_fin', 'like', '%'.$filter.'%')
        ->where('id_empresa_fin', $id_empresa)
        ->when($type, function ($query, $type) {
            return $query->where('tipo_transacao_fin', $type);
        })
        ->orderBy('id_financeiro_fin', 'desc')
        ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id_financeiro,Int $id_empresa) {

        $data = Financeiro::select('tb_financeiro.*', 'tb_centro_custo.des_centro_custo_cco','tb_metodo_pagamento.desc_metodo_pagamento_tmp')
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_financeiro.id_centro_custo_fin')
        ->join('tb_metodo_pagamento', 'tb_metodo_pagamento.id_metodo_pagamento_tmp', '=', 'tb_financeiro.id_metodo_pagamento_fin')
        ->where('id_financeiro_fin', $id_financeiro)
        ->where('id_empresa_fin', $id_empresa)
        ->where('is_ativo_fin', 1)
        ->first();

        return $data;
    }
}
