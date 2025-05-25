<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Estoque extends Model
{
    use HasFactory;
    protected $table = "tb_estoque";

    protected $primaryKey = 'id_estoque_est';

    protected $fillable = [
        'des_estoque_est',
        'id_centro_custo_est',
        'is_ativo_est',
        'id_empresa_est',
    ];

    public static function getAll($id_empresa, $id_usuario, $queryParams) {
        $query = Estoque::select([
            'tb_estoque.id_estoque_est',
            'tb_estoque.des_estoque_est',
            'tb_centro_custo.des_centro_custo_cco',
            'tb_estoque.created_at',
            'tb_estoque.updated_at'
        ])
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_centro_custo_est')
        ->where('is_ativo_est', 1)
        ->where('tb_estoque.des_estoque_est', 'like', '%'.$queryParams->filter.'%')
        ->where('tb_estoque.id_empresa_est', $id_empresa)
        ->when($queryParams->id_centro_custo, function ($query, $id_centro_custo) {
            return $query->where('tb_estoque.id_centro_custo_est', '=', $id_centro_custo);
        });

        if (!$queryParams->getByCompany) {
              $query->join('rel_usuario_estoque', 'tb_estoque.id_estoque_est', '=', 'rel_usuario_estoque.id_estoque_rue')
                ->where('rel_usuario_estoque.id_user_rue', $id_usuario);
        }

        $query = $query
        ->orderBy('tb_estoque.id_estoque_est', 'desc')
        ->paginate($queryParams->perPage, ['*'], 'page', $queryParams->pageNumber);

        return response()->json([
            'items' => $query->items(),
            'total' => $query->total(),
        ]);
    }

    public static function getById(Int $id_empresa, Int $id = null) {
        if($id) {
            $data = Estoque::select([
                'tb_estoque.id_estoque_est',
                'tb_estoque.des_estoque_est',
                'tb_estoque.id_centro_custo_est',
                'tb_centro_custo.des_centro_custo_cco',
                'tb_estoque.created_at' ,
                'tb_estoque.updated_at'
            ])
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_centro_custo_est')
            ->where('is_ativo_est', 1)
            ->where('id_estoque_est', $id)
            ->where('tb_estoque.id_empresa_est', $id_empresa)
            ->orderBy('tb_estoque.id_estoque_est', 'desc')
            ->get();
        } else {
            $data = Estoque::select([
                'tb_estoque.id_estoque_est',
                'tb_estoque.des_estoque_est',
                'tb_estoque.id_centro_custo_est',
                'tb_centro_custo.des_centro_custo_cco',
                'tb_estoque.created_at' ,
                'tb_estoque.updated_at'
            ])
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_centro_custo_est')
            ->where('is_ativo_est', 1)
            ->where('tb_estoque.id_empresa_est', $id_empresa)
            ->orderBy('tb_estoque.id_estoque_est', 'desc')
            ->get();
        }
        return response()->json($data);
    }

    public static function getEstoqueComValores($id_usuario, $id_empresa)
    {
        return DB::table('tb_estoque as te')
            ->join('tb_centro_custo as tcc', 'te.id_centro_custo_est', '=', 'tcc.id_centro_custo_cco') // Join com centro de custo
            ->join('rel_usuario_centro_custo as rucc', 'tcc.id_centro_custo_cco', '=', 'rucc.id_centro_custo_ccu') // Join com relação usuário-centro de custo
            ->leftJoin('tb_estoque_item as tei', 'te.id_estoque_est', '=', 'tei.id_estoque_eti') // Join com estoque_item
            ->leftJoin('tb_material as tm', 'tei.id_material_eti', '=', 'tm.id_material_mte') // Join com materiais
            ->select(
                'te.id_estoque_est as estoque_id',
                'te.des_estoque_est',
                'tcc.des_centro_custo_cco as centro_custo_descricao',
                'tm.id_material_mte as material_id',
                'tm.des_material_mte as material_descricao',
                DB::raw('COUNT(tei.id_material_eti) as total_itens'),
                DB::raw('SUM(tei.qtd_estoque_item_eti) as quantidade_total')
            )
            ->where('rucc.id_user', $id_usuario)
            ->where('te.is_ativo_est', 1)
            ->where('tm.is_ativo_mte', 1)
            ->where('te.id_empresa_est', $id_empresa)
            ->groupBy(
                'te.id_estoque_est',
                'te.des_estoque_est',
                'tcc.des_centro_custo_cco',
                'tm.id_material_mte',
                'tm.des_material_mte'
            )
            ->orderBy('te.des_estoque_est', 'asc')
            ->orderBy('tm.des_material_mte', 'asc')
            ->get();
    }

    public static function getEstoqueComValoresById(Int $id_estoque = null)
    {
        return DB::table('tb_estoque as te')
            ->leftJoin('tb_material_movimentacao as tmm', function ($join) {
                $join->on('te.id_estoque_est', '=', 'tmm.id_estoque_entrada_mov')
                     ->orOn('te.id_estoque_est', '=', 'tmm.id_estoque_saida_mov');
            })
            ->leftJoin('tb_material_movimentacao_item as tmmi', 'tmm.id_movimentacao_mov', '=', 'tmmi.id_movimentacao_mit')
            ->leftJoin('tb_material as tm', 'tmmi.id_material_mit', '=', 'tm.id_material_mte')
            ->select(
                'te.id_estoque_est as estoque_id',
                'te.des_estoque_est as estoque_descricao',
                'tm.id_material_mte as material_id',
                'tm.des_material_mte as material_descricao',
                'tm.vlr_material_mte as valor_unitario',
                DB::raw('COALESCE(SUM(CASE WHEN tmm.id_estoque_entrada_mov = te.id_estoque_est THEN tmmi.qtd_material_mit ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN tmm.id_estoque_saida_mov = te.id_estoque_est THEN tmmi.qtd_material_mit ELSE 0 END), 0) as quantidade_em_estoque'),
                DB::raw('(COALESCE(SUM(CASE WHEN tmm.id_estoque_entrada_mov = te.id_estoque_est THEN tmmi.qtd_material_mit ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN tmm.id_estoque_saida_mov = te.id_estoque_est THEN tmmi.qtd_material_mit ELSE 0 END), 0)) * tm.vlr_material_mte as valor_total_em_estoque')
            )
            ->where('te.is_ativo_est', 1)
            ->where('tm.is_ativo_mte', 1)
            ->where('te.id_estoque_est', $id_estoque)
            ->groupBy('te.id_estoque_est', 'tm.id_material_mte', 'tm.vlr_material_mte')
            ->orderBy('te.id_estoque_est', 'desc')
            ->orderBy('tm.des_material_mte', 'desc')
            ->get();
    }

    public static function updateReg(Int $id_empresa, Int $id_estoque, $obj) {
        estoque::
        where('id_estoque_est', $id_estoque)
        ->where('id_empresa_est', $id_empresa)
        ->update([
            'des_estoque_est' => $obj->des_estoque_est
        ]);
    }

    public static function deleteReg($id_estoque_est, $id_empresa) {
        Estoque::where('id_estoque_est', $id_estoque_est)
        ->where('id_empresa_est', $id_empresa)
        ->update([
            'is_ativo_est' => 0
        ]);
    }
}
