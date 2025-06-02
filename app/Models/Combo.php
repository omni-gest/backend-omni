<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Combo extends Model
{
    use HasFactory;

    protected $table = "tb_combo";
    protected $primaryKey = 'id_combo_cmb';
    protected $fillable = [
        'desc_combo_cmb',
        'id_empresa_cmb',
        'id_centro_custo_cmb',
        'vlr_combo_cmb',
    ];

    public static function getAll($id_empresa, $queryParams)
    {
        $paginator = Combo::select(
            'rcm.id_combo_material_cbm',
            'tc.desc_combo_cmb',
            'tc.id_centro_custo_cmb',
            'tc.id_empresa_cmb',
            'tm.id_material_mte',
            'tu.des_reduz_unidade_und',
            'vlr_combo_cmb',
            'tm.des_material_mte',
            'tm.vlr_material_mte',
            'tc.created_at',
            'tc.updated_at'
        )
            ->join('tb_combo as tc', 'tc.id_combo_cmb', '=', 'rcm.id_combo_cbm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rcm.id_material_cbm')
            ->join('tb_unidade as tu', 'tu.id_unidade_und', '=', 'tm.id_unidade_mte')
            ->where('tc.is_ativo_cmb', 1)
            ->where('tc.id_empresa_cmb', $id_empresa)
            ->when($queryParams->filter, function ($query, $filter) {
                return $query->where('tc.desc_combo_cmb', 'like', '%' . $filter . '%');
            })
            ->when($queryParams->id_centro_custo_cmb, function ($query, $id_centro_custo) {
                return $query->where('tc.id_centro_custo_cmb', $id_centro_custo);
            })
            ->orderBy('tc.id_combo_cmb', 'desc')
            ->paginate(
                $queryParams->perPage,
                ['*'],
                'page',
                $queryParams->pageNumber
            );

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }


    public static function getById($id_empresa, $id_combo)
    {
        $combo = Combo::select('tb_combo.*')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_combo.id_centro_custo_cmb')
            ->where('is_ativo_cmb', 1)
            ->where('id_empresa_cmb', $id_empresa)
            ->where('id_combo_cmb', $id_combo)
            ->first();

        if (!$combo) {
            return response()->json(['error' => 'Combo não encontrado'], 404);
        }

        $materiais = DB::table('rel_combo_material as rcm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rcm.id_material_cbm')
            ->join('tb_unidade as tu', 'tu.id_unidade_und', '=', 'tm.id_unidade_mte')
            ->select(
                'rcm.id_combo_material_cbm',
                'tm.id_material_mte as id_material',
                'tm.des_material_mte as nome_material',
                'tu.des_reduz_unidade_und as nome_unidade',
                'tm.vlr_material_mte as vlr_material',
                'rcm.qtd_material_cbm'
            )
            ->where('rcm.id_combo_cbm', $id_combo)
            ->get();

        $comboData = $combo->toArray();
        $comboData['materiais'] = $materiais;

        return $comboData;
    }

    public static function updateReg(int $id_empresa, int $id_combo_cmb, $obj)
    {
        Combo::where('id_combo_cmb', $id_combo_cmb)
            ->where('id_empresa_cmb', $id_empresa)
            ->update([
                'desc_combo_cmb' => $obj->desc_combo_cmb,
                'id_centro_custo_cmb' => $obj->id_centro_custo_cmb,
                'vlr_combo_cmb' => $obj->vlr_combo_cmb,
            ]);
    }

    public static function getAllFormatado($id_empresa, $queryParams)
    {
        $data = DB::table('rel_combo_material as rcm')
            ->select(
                'tc.id_combo_cmb as id_combo',
                'tc.desc_combo_cmb as desc_combo',
                'tc.id_centro_custo_cmb',
                'vlr_combo_cmb',
                'tc.id_empresa_cmb',
                'tc.created_at',
                'tc.updated_at',
                'tm.id_material_mte as id_material',
                'tm.des_material_mte as nome_material',
                'tu.des_reduz_unidade_und as nome_unidade',
                'des_centro_custo_cco',
                'tm.vlr_material_mte as vlr_material'
            )
            ->join('tb_combo as tc', 'tc.id_combo_cmb', '=', 'rcm.id_combo_cbm')
            ->join('tb_material as tm', 'tm.id_material_mte', '=', 'rcm.id_material_cbm')
            ->join('tb_unidade as tu', 'tu.id_unidade_und', '=', 'tm.id_unidade_mte')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'tc.id_centro_custo_cmb')
            ->where('tc.is_ativo_cmb', 1)
            ->where('tc.id_empresa_cmb', $id_empresa)
            ->when($queryParams->filter, function ($query, $filter) {
                return $query->where('tc.desc_combo_cmb', 'like', '%' . $filter . '%');
            })
            ->when($queryParams->id_centro_custo_cmb, function ($query, $id_centro_custo) {
                return $query->where('tc.id_centro_custo_cmb', $id_centro_custo);
            })
            ->orderBy('tc.id_combo_cmb', 'desc')
            ->get();

        $agrupado = $data->groupBy('id_combo')->map(function ($items, $id_combo) {
            $first = $items->first();

            return [
                'id_combo' => $id_combo,
                'desc_combo' => $first->desc_combo,
                'id_centro_custo' => $first->id_centro_custo_cmb,
                'des_centro_custo_cco' => $first->des_centro_custo_cco,
                'vlr_combo_cmb' => $first->vlr_combo_cmb,
                'id_empresa' => $first->id_empresa_cmb,
                'created_at' => $first->created_at,
                'updated_at' => $first->updated_at,
                'materiais' => $items->map(function ($item) {
                    return [
                        'id_material' => $item->id_material,
                        'nome_material' => $item->nome_material,
                        'nome_unidade' => $item->nome_unidade,
                        'vlr_material' => $item->vlr_material,
                    ];
                })->values()
            ];
        })->values();

        return $agrupado;
    }



}
