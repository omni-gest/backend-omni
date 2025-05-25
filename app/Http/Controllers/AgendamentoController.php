<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AgendaTipoServico;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\RelFuncionarioTipoServico;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;

class AgendamentoController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create($empresa, Request $request)
    {
        $request->validate([
            'hora'       => 'required|string|min:5|max:5',
            'date' => 'required|string|min:10|max:10',
            'id_func' => 'required|integer',
            'telefone_cliente_cli' => 'required|string|min:15|max:15',
            'des_cliente_cli' => 'required|string|min:5|max:255',
        ]);

        // remove todos os caracteres diferente de numero
        $telefone = preg_replace('/[^0-9]/', '', $request->telefone_cliente_cli);
        $cliente = Cliente::select(['*'])->where('telefone_cliente_cli', $telefone)->get();
        

        $cliente_id = null;
        if(count($cliente) == 0) {
            // criar cliente
            $cliente = Cliente::create([
                'des_cliente_cli' => $request->des_cliente_cli,
                'telefone_cliente_cli' => $telefone,
                'documento_cliente_cli' => $request->documento_cliente_cli ?? '',
                'endereco_cliente_cli' => $request->endereco_cliente_cli ?? '',
                'is_ativo_cli' => 1,
            ]);

            $cliente_id = $cliente->id;
        }else{
            $cliente_id = $cliente[0]->id_cliente_cli;
        }
        
        if($cliente_id == null){
            return response()->json(null,400);
        }

        $agenda = Agenda::create([
            'id_cliente_age'=>$cliente_id,
            'dth_agenda_age'=> $request->date . " " . $request->hora,
            'txt_agenda_age'=>$request->date,
            'id_funcionario_age'=> $request->id_func,
            'txt_agenda_age'=>$request->txt_agenda_age,
        ]);
        $agenda_id = $agenda->id;
        if(count($request->serviceType) > 0){
            foreach ($request->serviceType as $serviceType) {
                AgendaTipoServico::create([
                    'id_agenda_rat'=>$agenda_id,
                    'id_tipo_servico_rat'=>$serviceType['id_servico_tipo_stp'],
                    'vlr_tipo_servico_rat'=>$serviceType['vlr_servico_tipo_stp']
                ]);
            }
        }

        


        // $servico_tipo = Unidade::create([
        //     'des_unidade_und'       => $request->des_unidade_und,
        //     'des_reduz_unidade_und' => $request->des_reduz_unidade_und,
        //     'is_ativo_stp'          => 1,
        // ]);

        // return response()->json($servico_tipo,201);
    }
    public function getAgendasByCliente($empresa, $telefone)
    {
        $result = Agenda::byClienteTelefone($empresa, $telefone);
        return response()->json($result);
    }

    public function getHorariosByFunc($empresa, $id_funcionario, $data)
    {
        $result = Agenda::byFuncAndDay($id_funcionario, $data);
        $arrayAgenda = $result->toArray();


        $arrayHoras = $this->criarArrayHoras();
        $horasAgenda = $this->mapearHorasAgenda($arrayAgenda, $arrayHoras);
        // dd($horasAgenda);

        return response()->json($horasAgenda);
    }

    public function getProfissionaisByTipoServico($empresa, $tipos_servico)
    {
        $tipos_servico = explode(',',$tipos_servico);
        $tipos_servico = array_map(function($reg){ return intval($reg); }, $tipos_servico);

        $data = RelFuncionarioTipoServico::byTipoServico($tipos_servico);

        return response()->json($data);
    }

    public function getEmpresa($empresa = null)
    {
        $result = Empresa::findByCodigo($empresa);
        if (!isset($result[0])) {
            return response()->json(null, 404);
        }
        return response()->json($result[0]);
    }




    function criarArrayHoras()
    {
        $horas = array();

        $horaInicial = new DateTime('08:00');
        $horaFinal = new DateTime('19:00');

        $intervalo = new DateInterval('PT30M');

        $atual = clone $horaInicial;
        while ($atual <= $horaFinal) {
            $horas[] = array(
                "hora" => $atual->format('H:i'),
                "isOpen" => true
            );
            $atual->add($intervalo);
        }

        return $horas;
    }

    function mapearHorasAgenda($arrayAgenda, $arrayHoras)
    {
        foreach ($arrayAgenda as $item) {
            $dataHora = new DateTime($item['dth_agenda_age']);
            $horaFormatada = $dataHora->format('H:i');

            foreach ($arrayHoras as &$hora) {
                if ($hora['hora'] === $horaFormatada) {
                    $hora['isOpen'] = false;
                    break;
                }
            }
        }

        return $arrayHoras;
    }
}
