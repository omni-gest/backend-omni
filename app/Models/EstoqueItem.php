<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstoqueItem extends Model
{
    use HasFactory;

    protected $table = "tb_estoque_item";

    protected $fillable = [
        'id_material_eti',
        'id_empresa_eti',
        'des_estoque_item_eti',
        'id_estoque_eti',
        'qtd_estoque_item_eti',
    ];

    public static function getByEmpresa(Int $id_empresa, Int $per_page, Int $page_number) {
        $paginator = EstoqueItem::select(['*'])
        ->where('is_ativo_eti', 1)
        ->where('id_empresa_eti', $id_empresa)
        ->orderBy('id_estoque_item_eti', 'desc')
        ->paginate($per_page, ['*'], 'page', $page_number);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getByEstoqueMaterial(Int $id_estoque_eti, Int $id_material_eti) {
        $data = EstoqueItem::select(['*'])
        ->where('is_ativo_eti', 1)
        ->where('id_estoque_eti', $id_estoque_eti)
        ->where('id_material_eti', $id_material_eti);

        return $data->first();
    }

    public static function get(Int $id_empresa, Int $id_material, Int $id_centro_custo) {
        $data = EstoqueItem::select([
            'id_estoque_item_eti',
            'id_empresa_eti',
            'id_material_eti',
            'id_centro_custo_eti',
            'qtd_estoque_item_eti'
        ])
        ->where('is_ativo_eti', 1)
        ->where('id_empresa_eti', $id_empresa)
        ->where('id_material_eti', $id_material)
        ->where('id_centro_custo_eti', $id_centro_custo);

        return $data->first();
    }

    public static function getAll(Int $id_empresa, $filter, $perPage = 10, $pageNumber = 1) {
        $paginator = EstoqueItem::select([
            'tb_estoque_item.id_estoque_item_eti',
            'tb_estoque_item.des_estoque_item_eti',
            'tb_estoque_item.qtd_estoque_item_eti',
            'tb_estoque.des_estoque_est',
            'tb_centro_custo.des_centro_custo_cco',
            'tb_material.des_material_mte',
            'tb_estoque_item.created_at',
            'tb_estoque_item.updated_at'
        ])
        ->join('tb_estoque', 'tb_estoque.id_estoque_est', '=', 'tb_estoque_item.id_estoque_eti')
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_estoque.id_centro_custo_est')
        ->join('tb_material', 'tb_material.id_material_mte', '=', 'tb_estoque_item.id_material_eti')
        ->where('tb_estoque_item.is_ativo_eti', 1)
        ->when(!empty($filter), function ($query) use ($filter) {
            $query->where(function ($subQuery) use ($filter) {
                $subQuery->where('tb_estoque_item.des_estoque_item_eti', 'like', '%'.$filter.'%')
                         ->orWhere('tb_centro_custo.des_centro_custo_cco', 'like', '%'.$filter.'%');
            });
        })
        ->where('tb_estoque_item.id_empresa_eti', $id_empresa)
        ->orderBy('tb_estoque_item.id_estoque_item_eti', 'desc')
        ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function deleteReg($id_empresa, $id_estoque_item_eti) {
        EstoqueItem::
        where('id_estoque_item_eti', $id_estoque_item_eti)
        ->where('id_empresa_eti', $id_empresa)
        ->update([
            'is_ativo_eti' => 0
        ]);
    }

    public static function updateReg($id_empresa, $id_estoque_item_eti, $obj) {
        EstoqueItem::
        where('id_estoque_item_eti', $id_estoque_item_eti)
        ->where('id_empresa_eti', $id_empresa)
        ->update([
            'id_material_eti' => $obj->id_material_eti,
            'id_estoque_eti' => $obj->id_estoque_eti,
            'qtd_estoque_item_eti' => $obj->qtd_estoque_item_eti,
            'des_estoque_item_eti' => $obj->des_estoque_item_eti,
            'updated_at' => now(),
        ]);
    }

}
