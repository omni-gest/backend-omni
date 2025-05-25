<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'tb_servico';

    protected $fillable = [
        'txt_servico_ser',
        'vlr_servico_ser',
        'dta_agendamento_ser',
        'id_situacao_ser',
        'id_centro_custo_ser',
        'id_funcionario_servico_ser',
        'id_cliente_ser',
        'is_ativo_ser',
        'id_empresa_ser',
        'id_metodo_pagamento_ser'
    ];

    public static function get(Int $id_empresa, $id_servico = null, $filtros = null) {
        $data = Servico::select([
            'id_servico_ser'
            , 'txt_servico_ser'
            , 'vlr_servico_ser'
            , 'dta_agendamento_ser'
            , 'id_situacao_ser'
            , 'desc_situacao_tsi'
            , 'id_funcionario_servico_ser'
            , 'desc_funcionario_tfu'
            , 'id_centro_custo_ser'
            , 'id_cliente_ser'
            , 'tb_servico.created_at'
            , 'id_material_mte'
            , 'des_material_mte'
            , 'des_reduz_unidade_und'
            , 'vlr_material_rsm'
            , 'qtd_material_rsm'
            , 'id_servico_tipo_stp'
            , 'des_servico_tipo_stp'
            , 'vlr_tipo_servico_rst'
        ])
        ->join('tb_funcionarios', 'id_funcionario_servico_ser', '=', 'id_funcionario_tfu')
        ->join('tb_cliente', 'id_cliente_ser', '=', 'id_cliente_cli')
        ->join('tb_situacao', 'id_situacao_ser', '=', 'id_situacao_tsi')
        ->leftJoin('rel_servico_tipo_servico', 'id_servico_ser', '=', 'id_servico_rst')
        ->leftJoin('tb_servico_tipo', 'id_tipo_servico_rst', '=', 'id_servico_tipo_stp')
        ->leftJoin('rel_servico_material', 'id_servico_ser', '=', 'id_servico_rsm')
        ->leftJoin('tb_material', 'id_material_rsm', '=', 'id_material_mte')
        ->leftJoin('tb_unidade', 'id_unidade_mte', '=', 'id_unidade_und')
        ->where('tb_servico.id_empresa_ser', $id_empresa);

        if($id_servico){
            $data = $data->where('id_servico_ser', $id_servico);
        }
        $data = $data->where($filtros);
        $data = $data->where('is_ativo_ser', 1);
        $data = $data->orderBy('id_servico_ser', 'desc')
        // ->ddRawSql();
        ->get();
        return $data;
    }
    public static function getLast30Days(Int $id_empresa, $request) {

        $data = Servico::
        selectRaw('COUNT(1) as qtd, DATE_FORMAT(dta_agendamento_ser, "%d/%m/%Y") as dta_agendamento')
        ->where('dta_agendamento_ser', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 30 DAY)'))
        ->where('tb_servico.id_empresa_ser', $id_empresa)
        ->where('id_situacao_ser', 2);
        if(isset($request->centrocusto) && !empty($request->centrocusto)){
            $centroCusto = explode(',', $request->centrocusto);
            $data = $data->whereIn('id_centro_custo_ser', $centroCusto);
        }
        $data = $data->groupBy('dta_agendamento')
        ->orderBy('dta_agendamento', 'ASC')
        // ->ddRawSql();
        ->get();
        return $data;
    }
    public static function getLast30DaysPerFunc(Int $id_empresa, $request = null) {

        $data = Servico::selectRaw('COUNT(1) as qtd, desc_funcionario_tfu')
        ->join('tb_funcionarios', 'id_funcionario_servico_ser', '=', 'id_funcionario_tfu')
        ->where('dta_agendamento_ser', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 30 DAY)'))
        ->where('tb_servico.id_empresa_ser', $id_empresa)
        ->where('id_situacao_ser', 2);
        if(isset($request->centrocusto) && !empty($request->centrocusto)){
            $centroCusto = explode(',', $request->centrocusto);
            $data = $data->whereIn('id_centro_custo_ser', $centroCusto);
        }
        $data = $data->groupBy('desc_funcionario_tfu')
        ->orderBy('qtd', 'DESC')
        // ->ddRawSql();
        ->get();

        return $data;
    }
    public static function getLast30DaysPerTipoServico(Int $id_empresa, $request) {

        $data = Servico::selectRaw('COUNT(1) as qtd, des_servico_tipo_stp')
        ->join('rel_servico_tipo_servico', 'id_servico_ser', '=', 'id_servico_rst')
        ->join('tb_servico_tipo', 'id_tipo_servico_rst', '=', 'id_servico_tipo_stp')
        ->where('dta_agendamento_ser', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 30 DAY)'))
        ->where('tb_servico.id_empresa_ser', $id_empresa)
        ->where('id_situacao_ser', 2);
        if(isset($request->centrocusto) && !empty($request->centrocusto)){
            $centroCusto = explode(',', $request->centrocusto);
            $data = $data->whereIn('id_centro_custo_ser', $centroCusto);
        }
        $data = $data->groupBy('des_servico_tipo_stp')
        ->orderBy('qtd', 'DESC')
        // ->ddRawSql();
        ->get();
        return $data;
    }

    // public static function getAll() {
    //     $data = Unidade::select(['*'])->where('is_ativo_ser', 1)->get();
    //     return response()->json($data);
    // }

    // public static function getById(Int $id = null) {
    //     if($id) {
    //         $data = Unidade::select(['*'])->where('id_servico_ser', $id)->where('is_ativo_ser', 1)->get();
    //     }else{
    //         $data = Unidade::select(['*'])->where('is_ativo_ser', 1)->get();
    //     }
    //     return response()->json($data);
    // }

    public static function updateReg(Int $id_empresa, Int $id_servico, $obj) {
        Servico::where('id_servico_ser', $id_servico)
        ->where('id_empresa_ser', $id_empresa)
        ->update($obj);
    }

    public static function deleteReg(Int $id_empresa, $id_servico) {
        Servico::where('id_servico_ser', $id_servico)
        ->where('id_empresa_ser', $id_empresa)
        ->update([
            'is_ativo_ser' => 0
        ]);
    }

    public static function finalizarReg(Int $id_empresa, $id_servico) {
        Servico::where('id_servico_ser', $id_servico)
        ->where('id_empresa_ser', $id_empresa)
        ->update([
            'id_situacao_ser' => 2
        ]);
    }

    public static function getDashboardDados($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = DB::table('tb_servico as ts')
            ->join('tb_centro_custo as tcc', 'tcc.id_centro_custo_cco', '=', 'ts.id_centro_custo_ser');

        // Filtrando pelos centros de custo, caso seja fornecido
        if (!empty($centrosCusto)) {
            $query->whereIn('tcc.id_centro_custo_cco', $centrosCusto);
        }

        // Filtrando pelo intervalo de datas, caso seja fornecido
        if ($dataInicio && $dataFim) {
            $query->whereBetween('ts.created_at', [$dataInicio, $dataFim]);
        }

        return (array) $query->select([
            DB::raw("COUNT(CASE WHEN ts.id_situacao_ser = 1 AND ts.is_ativo_ser = 1 THEN 1 END) AS total_ativos"),
            DB::raw("COUNT(CASE WHEN ts.id_situacao_ser = 2 AND ts.is_ativo_ser = 1 THEN 1 END) AS total_finalizados"),
            DB::raw("COUNT(CASE WHEN ts.is_ativo_ser = 0 THEN 1 END) AS total_inativos"),
            DB::raw("
                COALESCE(
                    TIME_FORMAT(
                        SEC_TO_TIME(
                            AVG(
                                CASE
                                    WHEN ts.id_situacao_ser = 2 AND ts.is_ativo_ser = 1
                                    THEN TIMESTAMPDIFF(SECOND, ts.created_at, ts.updated_at)
                                    ELSE NULL
                                END
                            )
                        ),
                        '%H:%i:%s'
                    ),
                    '00:00:00'
                ) AS media_tempo_atendimento
            ")
        ])->first();
    }


    public static function getTopThreeEmployeesByTotalTypeService($limit = 3, $centrosCusto = [], $dataInicio = null, $dataFim = null)
{
    $query = DB::table('tb_servico as ts')
        ->join('tb_funcionarios as tf', 'ts.id_funcionario_servico_ser', '=', 'tf.id_funcionario_tfu')
        ->join('rel_servico_tipo_servico as rsts', 'ts.id_servico_ser', '=', 'rsts.id_servico_rst')
        ->select('tf.desc_funcionario_tfu as nome', DB::raw('COUNT(*) as total_tipos_servico'))
        ->groupBy('tf.id_funcionario_tfu', 'tf.desc_funcionario_tfu')
        ->orderByDesc('total_tipos_servico');

    if ($dataInicio && $dataFim) {
        $query->whereBetween('ts.created_at', [$dataInicio, $dataFim]);
    }

    if (!empty($centrosCusto)) {
        $query->whereIn('ts.id_centro_custo_ser', $centrosCusto);
    }

    return $query->limit($limit)->get();
}


}
