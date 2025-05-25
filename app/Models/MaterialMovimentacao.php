<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialMovimentacao extends Model
{
    use HasFactory;
    protected $table = "tb_material_movimentacao";

    protected $fillable = [
        'txt_movimentacao_mov',
        'id_estoque_entrada_mov',
        'id_estoque_saida_mov',
        'id_centro_custo_mov',
        'is_ativo_mov',
        'id_empresa_mov',
    ];

    public static function get(Int $id_empresa, $tipo_movimentacao, Int $id_material = null) {
        $data = MaterialMovimentacao::select([
            'tb_material_movimentacao.id_movimentacao_mov',
            'tb_centro_custo.id_centro_custo_cco',
            'tb_centro_custo.des_centro_custo_cco',
            'tb_material_movimentacao.txt_movimentacao_mov',
            'tb_material_movimentacao.id_estoque_entrada_mov',
            'estoque_entrada.des_estoque_est as des_estoque_entrada',
            'tb_material_movimentacao.id_estoque_saida_mov',
            'estoque_saida.des_estoque_est as des_estoque_saida',
            'tb_material_movimentacao.id_centro_custo_mov',
            'tb_material_movimentacao_item.id_material_mit',
            'tb_material.des_material_mte',
            'tb_unidade.des_reduz_unidade_und',
            'tb_material_movimentacao_item.qtd_material_mit',
            'tb_material.id_material_mte',
            'tb_material.vlr_material_mte',
            'tb_material_movimentacao.created_at',
        ])
        ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_material_movimentacao.id_centro_custo_mov')
        ->join('tb_material_movimentacao_item', 'tb_material_movimentacao_item.id_movimentacao_mit', '=', 'tb_material_movimentacao.id_movimentacao_mov')
        ->join('tb_material', 'tb_material.id_material_mte', '=', 'tb_material_movimentacao_item.id_material_mit')
        ->join('tb_unidade', 'tb_unidade.id_unidade_und', '=', 'tb_material.id_unidade_mte')
        ->leftJoin('tb_estoque as estoque_entrada', 'estoque_entrada.id_estoque_est', '=', 'tb_material_movimentacao.id_estoque_entrada_mov')
        ->leftJoin('tb_estoque as estoque_saida', 'estoque_saida.id_estoque_est', '=', 'tb_material_movimentacao.id_estoque_saida_mov')
        ->where('tb_material_movimentacao_item.tipo_movimentacao_mit', '=', $tipo_movimentacao);

        if($id_material){
            $data = $data->where('id_material_mte', $id_material);
        }
        $data = $data->where('is_ativo_mov', 1);
        $data = $data->where('tb_material_movimentacao.id_empresa_mov', $id_empresa);
        $data = $data->orderBy('tb_material_movimentacao.id_movimentacao_mov', 'desc')
        ->get();
        return $data;
    }

    public static function updateReg(Int $id_empresa, Int $id, $obj) {
        MaterialMovimentacao::where('id_movimentacao_mov', $id)
        ->where('id_empresa_mov', $id_empresa)
        ->update([
            'txt_movimentacao_mov' => $obj->txt_movimentacao_mov
        ]);
    }

    public static function deleteReg($id_empresa, $id) {
        MaterialMovimentacao::where('id_movimentacao_mov', $id)
        ->where('id_empresa_mov', $id_empresa)
        ->update([
            'is_ativo_mov' => 0
        ]);
    }
}
