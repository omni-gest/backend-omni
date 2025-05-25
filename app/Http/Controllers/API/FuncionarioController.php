<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\RelFuncionarioTipoServico;
use Illuminate\Http\Request;


class FuncionarioController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/funcionario",
     *     summary="Cria um novo funcionário",
     *     tags={"Funcionario"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Funcionário criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'id_funcionario_cargo_tfu'  => 'required|int|max:255',
            'desc_funcionario_tfu'      => 'required|string|max:255',
            'documento_funcionario_tfu' => 'required|string|max:255',
            'telefone_funcionario_tfu'  => 'required|string|max:255',
            'endereco_funcionario_tfu'  => 'required|string|max:255',
            'id_centro_custo_tfu'       => 'required|integer|'
        ]);

        $funcionario = Funcionario::create([
            'id_funcionario_cargo_tfu'   => $request->id_funcionario_cargo_tfu,
            'desc_funcionario_tfu'       => $request->desc_funcionario_tfu,
            'documento_funcionario_tfu'  => $request->documento_funcionario_tfu,
            'telefone_funcionario_tfu'   => $request->telefone_funcionario_tfu,
            'endereco_funcionario_tfu'   => $request->endereco_funcionario_tfu,
            'id_centro_custo_tfu'        => $request->id_centro_custo_tfu,
            'id_empresa_tfu'             => $id_empresa,
        ]);
        if($request->tipos_servico){
            foreach ($request->tipos_servico as $tipo_servico) {
                RelFuncionarioTipoServico::create([
                    'id_funcionario_rft'  => $funcionario->id,
                    'id_tipo_servico_rft' => $tipo_servico['value']
                ]);
            }
        }

        return response()->json($funcionario,201);
    }

    /**
     * @OA\Get(
     *     path="/funcionario/{id_funcionario}",
     *     summary="Recupera um funcionário pelo ID",
     *     tags={"Funcionario"},
     *     @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         required=true,
     *         description="ID do funcionário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Funcionário recuperado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Funcionário não encontrado"
     *     )
     * )
     */
    public function get(Request $request, $id_funcionario = null) {
        $id_empresa = $this->getIdEmpresa($request);
        if($id_funcionario){
            $data = Funcionario::getById($id_empresa,$id_funcionario);
            $data_array = json_decode($data);

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Funcionário Não Existe',],400);
            }
            return $data;
        }

        $queryParams = (object) [
            'perPage' => $request->query('per_page', 10),
            'filter' => $request->query('filter', ''),
            'pageNumber' => $request->query('page_number', 1),
            'id_centro_custo_tfu' => $request->query('id_centro_custo_tfu', null),
        ];
        $data = Funcionario::getAll($id_empresa, $queryParams);

        $data = json_decode($data->content(), true);

        $itemsArray = $data['items'];
        $itemsGrouped = $this->groupByTypeService($itemsArray);

        // Mantém os metadados de paginação e substitui os itens processados
        $data['items'] = $itemsGrouped;

        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/funcionario/{id_funcionario}",
     *     summary="Atualiza um funcionário",
     *     tags={"Funcionario"},
     *     @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         required=true,
     *         description="ID do funcionário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Funcionário atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação ou funcionário não encontrado"
     *     )
     * )
     */
    public function update(Int $id_funcionario, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'id_funcionario_cargo_tfu'  => 'required|int|max:255',
            'desc_funcionario_tfu'      => 'required|string|max:255',
            'documento_funcionario_tfu' => 'required|string|max:255',
            'telefone_funcionario_tfu'  => 'required|string|max:255',
            'endereco_funcionario_tfu'  => 'required|string|max:255',
            'id_centro_custo_tfu'       => 'integer'
        ]);
        Funcionario::updateReg($id_empresa, $id_funcionario, $request);

        $funcionarioData = Funcionario::getById($id_empresa, $id_funcionario);

        $input_array = $funcionarioData->toArray();

        $funcionarioData = $this->groupByTypeService($input_array);

        if($request->tipos_servico){
            $tipoServicoRemove = [];
            $tipoServicoNew = [];
            $tipoServicoAlreadyRegistered = $funcionarioData[0]['tipos_servico'];
            foreach ($tipoServicoAlreadyRegistered as $key => $old) {
                $exists = false;
                foreach ($request->tipos_servico as $key => $new) {
                    if ($old['id_servico_tipo_stp'] == $new['value']) {
                        $exists = true;
                        break;
                    }
                }
                if ($exists == false) {
                    $tipoServicoRemove[] = $old;
                }
            }

            $tipoServicoNew = array_filter($request->tipos_servico, function ($reg) use ($tipoServicoAlreadyRegistered) {
                foreach ($tipoServicoAlreadyRegistered as $value) {
                    if ($value['id_servico_tipo_stp'] == $reg['value'])
                        return false;
                }
                return true;
            });
            foreach ($tipoServicoNew as $tipo_servico) {
                RelFuncionarioTipoServico::create([
                    'id_funcionario_rft' => $id_funcionario,
                    'id_tipo_servico_rft' => $tipo_servico['value']
                ]);
            }
            foreach ($tipoServicoRemove as $tipo_servico) {
                $relFuncionarioTipoServico = RelFuncionarioTipoServico::where('id_funcionario_rft', $id_funcionario)
                ->where('id_tipo_servico_rft', $tipo_servico['id_servico_tipo_stp'])
                ->first();

                $delete = RelFuncionarioTipoServico::where('id_rel_rft', $relFuncionarioTipoServico->id_rel_rft)->first();

                $delete->delete();
            }
        }
    }

    /**
     * @OA\Delete(
     *     path="/funcionario/{id_funcionario}",
     *     summary="Deleta um funcionário",
     *     tags={"Funcionario"},
     *     @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         required=true,
     *         description="ID do funcionário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Funcionário deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Funcionário não encontrado"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_funcionario) {
        $id_empresa = $this->getIdEmpresa($request);
        Funcionario::deleteReg($id_empresa, $id_funcionario);
    }

    private function groupByTypeService($input_array){
        // variavel de saida
        $output_array = [];

        // agrupa materiais e tipos de servico por servico
        foreach ($input_array as $item) {
            $id = $item['id_funcionario_tfu'];
            if (!isset($output_array[$id])) {
                $output_array[$id] = [...$item,
                    'tipos_servico' => [],
                ];
                unset($output_array[$id]['id_servico_tipo_stp']);
                unset($output_array[$id]['des_servico_tipo_stp']);
            }

            if ($item['id_servico_tipo_stp'] !== null) {
                $temp = array_filter($output_array[$id]['tipos_servico'], function ($reg) use($item) { return $reg['id_servico_tipo_stp'] == $item['id_servico_tipo_stp']; });
                if(count($temp) == 0) {
                    $output_array[$id]['tipos_servico'][] = [
                        "id_servico_tipo_stp" => $item['id_servico_tipo_stp'],
                        "des_servico_tipo_stp" => $item['des_servico_tipo_stp'],
                    ];
                }
            }
        }

        // Converte o array associativo em um array indexado
        $output_array = array_values($output_array);
        return $output_array;
    }
}
