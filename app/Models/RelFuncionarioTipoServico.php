<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelFuncionarioTipoServico extends Model
{
    use HasFactory;

    protected $table = 'rel_funcionarios_tipo_servico';

    protected $primaryKey = 'id_rel_rft';

    protected $fillable = [
        'id_funcionario_rft',
        'id_tipo_servico_rft'
    ];


    public static function byTipoServico($tipos_servico = []) {
        $data = RelFuncionarioTipoServico::select(['desc_funcionario_tfu', 'id_funcionario_tfu'])
        ->join('tb_funcionarios','id_funcionario_rft','=','id_funcionario_tfu')
        ->whereIn('id_tipo_servico_rft',$tipos_servico)
        ->get();
        return $data;
    }

    // public static function byClienteTelefone($empresa, $telefone) {
    //     $data = Agenda::select(['dth_agenda_age','desc_funcionario_tfu'])
    //     ->join('tb_cliente', 'id_cliente_age','=' ,'id_cliente_cli')
    //     ->join('tb_funcionarios', 'id_funcionario_age','=' ,'id_funcionario_tfu')
    //     ->where('telefone_cliente_cli', $telefone)
    //     ->orderby('dth_agenda_age','ASC')
    //     // ->toSql();
    //     ->get();
    //     // dd($data);

    //     return $data;
    // }
}
