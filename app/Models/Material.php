<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Material extends Model
{
    use HasFactory;

    protected $table = "tb_material";

    protected $fillable = [
        'id_unidade_mte',
        'des_material_mte',
        'vlr_material_mte',
        'id_centro_custo_mte',
        'is_ativo_mte',
        'id_empresa_mte',
    ];

    public static function getAll($id_empresa, $queryParams)
    {
        $descricaoMaterialSql = $queryParams->verificar_estoque && $queryParams->id_estoque != null
            ? "CASE
        WHEN tb_estoque_item.qtd_estoque_item_eti <= 0 OR tb_estoque_item.qtd_estoque_item_eti IS NULL
        THEN CONCAT('(SEM ESTOQUE) ', tb_material.des_material_mte)
        ELSE tb_material.des_material_mte
       END AS des_material_mte"
            : "tb_material.des_material_mte AS des_material_mte";

        $data = Material::select([
            'tb_material.id_material_mte',
            DB::raw($descricaoMaterialSql),
            'tb_material.vlr_material_mte',
            'tb_unidade.des_reduz_unidade_und',
            'tb_material.is_ativo_mte',
            'tb_material.created_at',
            'tb_material.updated_at',
            'tb_centro_custo.des_centro_custo_cco'
        ])
            ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte');

        if ($queryParams->id_estoque != null) {
            $data = $data->leftJoin('tb_estoque_item', function ($join) use ($id_estoque) {
                $join->on('tb_estoque_item.id_material_eti', '=', 'tb_material.id_material_mte')
                    ->where('tb_estoque_item.id_estoque_eti', '=', $id_estoque);
            });
        }

        $data = $data
            ->leftjoin('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_material.id_centro_custo_mte')
            ->where('is_ativo_mte', 1)
            ->when($queryParams->id_centro_custo_mte, function ($query, $id_centro_custo_mte) {
                return $query->where('tb_material.id_centro_custo_mte', $id_centro_custo_mte);
            })
            ->where('tb_material.id_empresa_mte', $id_empresa)
            ->orderBy('id_material_mte', 'desc')
            ->get();

        return response()->json($data);
    }

    public static function getById(int $id_empresa, int $id = null)
    {
        if ($id) {
            $data = Material::select([
                'tb_material.id_material_mte',
                'tb_material.des_material_mte',
                'tb_material.vlr_material_mte',
                'tb_unidade.des_reduz_unidade_und',
                'tb_material.is_ativo_mte',
                'tb_material.created_at',
                'tb_material.updated_at',
                'tb_centro_custo.des_centro_custo_cco'
            ])
                ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
                ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_material.id_centro_custo_mte')
                ->where('id_material_mte', $id)
                ->where('is_ativo_mte', 1)
                ->where('tb_material.id_empresa_mte', $id_empresa)
                ->get();
            return response()->json($data);
        } else {
            $data = Material::select([
                'tb_material.id_material_mte',
                'tb_material.des_material_mte',
                'tb_material.vlr_material_mte',
                'tb_unidade.des_reduz_unidade_und',
                'tb_material.is_ativo_mte',
                'tb_material.created_at',
                'tb_material.updated_at',
                'tb_centro_custo.des_centro_custo_cco'
            ])
                ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
                ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_material.id_centro_custo_mte')
                ->where('is_ativo_mte', 1)
                ->where('tb_material.id_empresa_mte', $id_empresa)
                ->orderBy('id_material_mte', 'desc')
                ->get();
            return response()->json($data);
        }
    }

    public static function updateReg(int $id_empresa, int $id_material, $obj)
    {
        Material::where('id_material_mte', $id_material)
            ->where('id_empresa_mte', $id_empresa)
            ->update([
                'des_material_mte' => $obj->des_material_mte,
                'id_unidade_mte' => $obj->id_unidade_mte,
                'vlr_material_mte' => $obj->vlr_material_mte,
                'id_centro_custo_mte' => $obj->id_centro_custo_mte,
            ]);
    }

    public static function deleteReg($id_empresa, $id_material)
    {
        Material::where('id_material_mte', $id_material)
            ->where('id_empresa_mte', $id_empresa)
            ->update([
                'is_ativo_mte' => 0
            ]);
    }
}
