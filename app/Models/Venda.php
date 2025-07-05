<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\RelVendaMaterial;

class Venda extends Model
{
    use HasFactory;

    protected $table = "tb_venda";

    protected $fillable = [
        'id_venda_vda',
        'id_funcionario_vda',
        'id_centro_custo_vda',
        'id_estoque_vda',
        'id_cliente_vda',
        'desc_venda_vda',
        'id_empresa_vda',
        'id_status_vda',
        'id_metodo_pagamento_vda',
    ];

    public static function get(int $id_empresa, $id = null, $filtros = null, $per_page = 1, $page_number = 0)
    {
        $paginator = Venda::select([
            'tb_venda.id_venda_vda',
            'tb_venda.id_funcionario_vda',
            'tb_funcionarios.desc_funcionario_tfu',
            'tb_venda.id_centro_custo_vda',
            'tb_venda.id_estoque_vda',
            'tb_centro_custo.des_centro_custo_cco',
            'tb_venda.id_cliente_vda',
            'tb_cliente.des_cliente_cli',
            'tb_cliente.telefone_cliente_cli',
            'tb_cliente.documento_cliente_cli',
            'tb_venda.desc_venda_vda',
            'tb_status.des_status_sts',
            'tb_status.status_sts',
            'tb_venda.id_status_vda',
            'tb_venda.created_at',
            DB::raw('SUM(rel_venda_material.vlr_unit_material_rvm * rel_venda_material.qtd_material_rvm) as total_vlr_material')
        ])
            ->join('tb_funcionarios', 'tb_venda.id_funcionario_vda', '=', 'tb_funcionarios.id_funcionario_tfu')
            ->join('tb_status', 'tb_venda.id_status_vda', '=', 'tb_status.id_status_sts')
            ->leftJoin('tb_cliente', 'tb_venda.id_cliente_vda', '=', 'tb_cliente.id_cliente_cli')
            ->join('tb_centro_custo', 'tb_venda.id_centro_custo_vda', '=', 'tb_centro_custo.id_centro_custo_cco')
            ->join('rel_venda_material', 'tb_venda.id_venda_vda', '=', 'rel_venda_material.id_venda_rvm')
            ->where('tb_venda.is_deleted', 0)
            ->where('tb_venda.id_empresa_vda', $id_empresa)
            ->groupBy('tb_venda.id_venda_vda', 'tb_venda.id_funcionario_vda', 'tb_funcionarios.desc_funcionario_tfu')
            ->orderBy('id_venda_vda', 'desc')
            ->paginate($per_page, ['*'], 'page', $page_number);

        if ($filtros) {
            $paginator = $paginator->where($filtros);
        }

        if ($id) {
            $paginator = $paginator->where('id_venda_vda', $id);
            return $paginator->first();
        }

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getMateriais(int $id_empresa, int $id_venda, $filtros = null)
    {
        $data = RelVendaMaterial::select([
            'rel_venda_material.id',
            'rel_venda_material.id_venda_rvm',
            'tb_material.des_material_mte',
            'rel_venda_material.id_material_rvm',
            'rel_venda_material.vlr_unit_material_rvm',
            'rel_venda_material.qtd_material_rvm',
            'tb_unidade.des_reduz_unidade_und'
        ])
            ->where('id_venda_rvm', $id_venda)
            ->join('tb_material', 'rel_venda_material.id_material_rvm', '=', 'tb_material.id_material_mte')
            ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
            ->join('tb_venda', 'tb_venda.id_venda_vda', '=', 'rel_venda_material.id_venda_rvm')
            ->where('tb_venda.id_empresa_vda', $id_empresa)
            ->orderBy('rel_venda_material.id', 'desc')
            ->get();

        if ($filtros) {
            $data = $data->where($filtros);
        }

        return $data;
    }
    public static function getCombos(int $id_empresa, int $id_venda, $filtros = null)
    {
        $data = \App\Models\RelVendaCombo::select([
            'rel_venda_combo.id',
            'rel_venda_combo.id_venda_rvc',
            'rel_venda_combo.id_combo_rvc as id_combo',
            'rel_venda_combo.qtd_combo_rvc as qtd_combo',
            'tb_combo.desc_combo_cmb as desc_combo',
            'tb_combo.vlr_combo_cmb'
        ])
            ->where('rel_venda_combo.id_venda_rvc', $id_venda)
            ->join('tb_combo', 'rel_venda_combo.id_combo_rvc', '=', 'tb_combo.id_combo_cmb')
            ->join('tb_venda', 'tb_venda.id_venda_vda', '=', 'rel_venda_combo.id_venda_rvc')
            ->where('tb_venda.id_empresa_vda', $id_empresa)
            ->orderBy('rel_venda_combo.id', 'desc')
            ->get();

        if ($filtros) {
            $data = $data->where($filtros);
        }

        return $data;
    }

    public static function deleteReg(int $id_empresa, int $id_venda)
    {
        Venda::where('id_venda_vda', $id_venda)
            ->where('id_empresa_vda', $id_empresa)
            ->update([
                'is_deleted' => 0
            ]);
    }

    public static function updateReg(int $id_empresa, int $id_venda_vda, $obj)
    {
        Venda::where('id_venda_vda', $id_venda_vda)
            ->where('id_empresa_vda', $id_empresa)
            ->update($obj);
    }

    public static function atualizarStatus(int $id_empresa, int $id_venda, int $id_status_sts)
    {
        Venda::where('id_venda_vda', $id_venda)
            ->where('id_empresa_vda', $id_empresa)
            ->update([
                'id_status_vda' => $id_status_sts
            ]);
    }

    public static function lancarVendaFinanceiro(Int $id_venda_vda)
    {
        DB::insert("
                INSERT INTO tb_financeiro (
                    desc_financeiro_fin,
                    vlr_financeiro_fin,
                    tipo_transacao_fin,
                    id_empresa_fin,
                    id_centro_custo_fin,
                    id_metodo_pagamento_fin,
                    is_ativo_fin,
                    tipo_referencia_fin,
                    id_venda_fin,
                    created_at
                )
                SELECT
                    COALESCE(v.desc_venda_vda, 'Venda') AS desc_financeiro_fin,
                    COALESCE(SUM(vm.vlr_unit_material_rvm * vm.qtd_material_rvm), 0) +
                    COALESCE(SUM(c.vlr_combo_cmb * rvc.qtd_combo_rvc), 0) AS vlr_financeiro_fin,
                    0 AS tipo_transacao_fin,
                    v.id_empresa_vda AS id_empresa_fin,
                    v.id_centro_custo_vda AS id_centro_custo_fin,
                    v.id_metodo_pagamento_vda AS id_metodo_pagamento_fin,
                    1 AS is_ativo_fin,
                    1 AS tipo_referencia_fin,
                    v.id_venda_vda,
                    v.created_at
                FROM tb_venda v
                LEFT JOIN rel_venda_material vm ON vm.id_venda_rvm = v.id_venda_vda
                LEFT JOIN rel_venda_combo rvc ON rvc.id_venda_rvc = v.id_venda_vda
                LEFT JOIN tb_combo c ON c.id_combo_cmb = rvc.id_combo_rvc
                WHERE v.id_venda_vda = ?
                GROUP BY
                    v.id_venda_vda,
                    v.desc_venda_vda,
                    v.id_centro_custo_vda,
                    v.id_metodo_pagamento_vda,
                    v.created_at,
                    v.id_empresa_vda
        ", [$id_venda_vda]);
    }
}
