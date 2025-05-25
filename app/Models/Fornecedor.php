<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = "tb_fornecedor";

    protected $fillable = [
        'desc_fornecedor_frn',
        'tel_fornecedor_frn',
        'documento_fornecedor_frn',
        'is_ativo_frn',
        'id_empresa_frn'
    ];

    public static function getAll($id_empresa, $filter, $perPage = 10, $pageNumber = 1)
    {
        $paginator = Fornecedor::
        select(['*'])
        ->where('is_ativo_frn', 1)
        ->where('desc_fornecedor_frn', 'like', '%'.$filter.'%')
        ->where('id_empresa_frn', $id_empresa)
        ->orderBy('id_fornecedor_frn', 'desc')
        ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id_empresa, Int $id = null){
        if($id){
            $data = Fornecedor::
            select(['*'])
            ->where('id_fornecedor_frn', $id)
            ->where('is_ativo_frn', 1)
            ->where('id_empresa_frn', $id_empresa)
            ->get();
            return response()->json($data);
        }
    }

    public static function updateReg(Int $id_fornecedor, $id_empresa, $obj) {
        Fornecedor::where('id_fornecedor_frn', $id_fornecedor)
        ->where('id_empresa_frn', $id_empresa)
        ->update([
            'desc_fornecedor_frn'       => $obj->desc_fornecedor_frn,
            'tel_fornecedor_frn'        => $obj->tel_fornecedor_frn,
            'documento_fornecedor_frn'  => $obj->documento_fornecedor_frn

        ]);
    }

    public static function deleteReg($id_empresa,$id_fornecedor) {
        Fornecedor::where('id_fornecedor_frn', $id_fornecedor)
        ->where('id_empresa_frn', $id_empresa)
        ->update([
            'is_ativo_frn' => 0
        ]);
    }

}
