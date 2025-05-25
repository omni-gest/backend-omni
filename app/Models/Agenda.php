<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'tb_servico_agenda';

    protected $fillable = [
        'dth_agenda_age',
        'txt_agenda_age',
        'id_situacao_age',
        'id_funcionario_age',
        'id_servico_age',
        'id_cliente_age',
    ];


    public static function byFuncAndDay($id_func, $day) {
        $data = Agenda::select(['*'])->where('id_funcionario_age', $id_func)->whereBetween('dth_agenda_age', [$day.' 00:00', $day.' 23:59'])->where('id_situacao_age','<>', 12)->get();
        return $data;
    }

    public static function byClienteTelefone($empresa, $telefone) {
        $data = Agenda::select(['dth_agenda_age','desc_funcionario_tfu'])
        ->join('tb_cliente', 'id_cliente_age','=' ,'id_cliente_cli')
        ->join('tb_funcionarios', 'id_funcionario_age','=' ,'id_funcionario_tfu')
        ->where('telefone_cliente_cli', $telefone)
        ->orderby('dth_agenda_age','ASC')
        // ->toSql();
        ->get();
        // dd($data);

        return $data;
    }

}
