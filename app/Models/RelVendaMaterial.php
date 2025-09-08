<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RelVendaMaterial extends Model
{
    use HasFactory;

    protected $table = 'rel_venda_material';

    protected $fillable = [
        'id_material_rvm',
        'id_venda_rvm',
        'vlr_unit_material_rvm',
        'qtd_material_rvm',
    ];

    public static function deleteReg($id)
    {
        RelVendaMaterial::where('id', $id)
            ->delete();
    }

    public static function updateReg(Int $id, $obj) {
        RelVendaMaterial::where('id', $id)
        ->update($obj);
    }

    public static function getByIdVenda(Int $id_venda) {
        $materiaisVenda = RelVendaMaterial::
        where('id_venda_rvm', $id_venda)
        ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rel_venda_material.id_material_rvm')
        ->get();

        return $materiaisVenda->toArray();
    }

    public static function getTotalMateriaisPorVenda($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rvm.id_material_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda')
            ->where('tv.id_status_vda', 3);

        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->select([
                'tm.des_material_mte as nome_material',
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm) as quantidade_vendida')
            ])
            ->groupBy('tm.id_material_mte', 'tm.des_material_mte')
            ->orderByDesc('quantidade_vendida')
            ->limit(10)
            ->get();
    }

    public static function getValorMateriaisPorVenda($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rvm.id_material_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda')
            ->where('tv.id_status_vda', 3);
        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->select([
                'tm.des_material_mte as nome_material',
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm * rvm.vlr_unit_material_rvm) as valor_total_vendido')
            ])
            ->groupBy('tm.id_material_mte', 'tm.des_material_mte')
            ->orderByDesc('valor_total_vendido')
            ->limit(10)
            ->get();
    }

    public static function getTopTresFuncionariosPorVenda($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rvm.id_material_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda')
            ->join('tb_funcionarios as tf', 'tv.id_funcionario_vda', '=', 'tf.id_funcionario_tfu')
            ->where('tv.id_status_vda', 3);
        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->select([
                'tf.desc_funcionario_tfu as nome_funcionario',
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm) as quantidade_vendida'),
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm * rvm.vlr_unit_material_rvm) as valor_total_vendido')
            ])
            ->groupBy('tf.id_funcionario_tfu', 'tf.desc_funcionario_tfu')
            ->orderByDesc('quantidade_vendida')
            ->limit(3)
            ->get();
    }

    public static function getVendasPorCentroCusto($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rvm.id_material_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda')
            ->where('tv.id_status_vda', 3);
        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->select([
                'tcc.des_centro_custo_cco',
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm) as quantidade_vendida'),
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm * rvm.vlr_unit_material_rvm) as valor_total_vendido'),
            ])
            ->groupBy('tcc.id_centro_custo_cco', 'tcc.des_centro_custo_cco')
            ->orderByDesc('quantidade_vendida')
            ->limit(10)
            ->get();
    }

    public static function getVendasPorCliente($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda')
            ->join('tb_cliente as tc', 'tc.id_cliente_cli', '=', 'tv.id_cliente_vda')
            ->where('tv.id_status_vda', 3);

        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->select([
                'tc.des_cliente_cli',
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm) as quantidade_vendida'),
                RelVendaMaterial::raw('SUM(rvm.qtd_material_rvm * rvm.vlr_unit_material_rvm) as valor_total_vendido'),
            ])
            ->groupBy('tc.id_cliente_cli', 'tc.des_cliente_cli')
            ->orderByDesc('quantidade_vendida')
            ->limit(10)
            ->get();
    }

    public static function getTotalVendasPorOrigemCliente($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda')
            ->join('tb_cliente as tc', 'tc.id_cliente_cli', '=', 'tv.id_cliente_vda')
            ->join('tb_origem_cliente as toc', 'toc.id_origem_cliente_orc', '=', 'tc.id_origem_cliente_cli');
            $query->whereIn("tv.id_status_vda", [1,2,3]);

        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->select([
                'toc.desc_origem_cliente_orc',
                RelVendaMaterial::raw('COUNT(DISTINCT tv.id_venda_vda) AS total_vendas'),
            ])
            ->groupBy('toc.id_origem_cliente_orc', 'toc.desc_origem_cliente_orc')
            ->orderByDesc('total_vendas')
            ->get();
    }

    public static function getTotalVendas($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = RelVendaMaterial::query()
            ->from('rel_venda_material as rvm')
            ->join('tb_venda as tv', 'tv.id_venda_vda', '=', 'rvm.id_venda_rvm')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tv.id_centro_custo_vda')
            ->where('tv.id_status_vda', 3);

        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('tv.created_at', [$dataInicio, $dataFim]);
        }

        return $query->selectRaw('
            COUNT(DISTINCT tv.id_venda_vda) as total_vendas,
            SUM(rvm.qtd_material_rvm * rvm.vlr_unit_material_rvm) as valor_total
        ')->first();
    }






}
