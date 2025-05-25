<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = "tb_cargos";

    protected $primaryKey = 'id_cargo_tcg';

    protected $fillable = [
        'desc_cargo_tcg',
        'is_ativo_tcg',
        'id_empresa_tcg'
    ];

    public static function getAll($id_empresa, $filter, $perPage = 10, $pageNumber = 1) {
        $paginator = Cargo::
            select(['*'])
            ->where('is_ativo_tcg', 1)
            ->where('desc_cargo_tcg', 'like', '%'.$filter.'%')
            ->where('id_empresa_tcg', $id_empresa)
            ->orderBy('id_cargo_tcg', 'desc')
            ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(Int $id_empresa, Int $id = null) {
        if($id) {
            $data = Cargo::select(['*'])
            ->where('id_cargo_tcg', $id)
            ->where('is_ativo_tcg', 1)
            ->where('id_empresa_tcg', $id_empresa)
            ->orderBy('id_cargo_tcg', 'desc')
            ->get();
        }else{
            $data = Cargo::select(['*'])
            ->where('is_ativo_tcg', 1)
            ->where('id_empresa_tcg', $id_empresa)
            ->orderBy('id_cargo_tcg', 'desc')
            ->get();
        }
        return response()
        ->json($data);
    }

    public static function updateReg(Int $id_empresa, Int $id_cargo, $obj) {
        Cargo::
        where('id_cargo_tcg', $id_cargo)
        ->where('id_empresa_tcg', $id_empresa)
        ->update([
            'desc_cargo_tcg' => $obj->desc_cargo_tcg
        ]);
    }

    public static function deleteReg($id_empresa, $id_cargo) {
        // Cargo::where('id_cargo_tcg', $id_cargo)
        // ->update([
        //     'is_ativo_tcg' => 0
        // ]);
        $delete = Cargo::
        where('id_cargo_tcg', $id_cargo)
        ->where('id_empresa_tcg', $id_empresa)
        ->first();
        $delete->delete();
    }

}
