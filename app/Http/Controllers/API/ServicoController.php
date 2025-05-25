<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Servico;
use App\Models\RelServicoTipoServico;
use App\Models\RelServicoMaterial;
use App\Models\Material;
use App\Models\ServicoTipo;
use Illuminate\Http\Request;
use App\Interfaces\ServicoRepositoryInterface;


class ServicoController extends Controller
{
    public function __construct(
        private ServicoRepositoryInterface $servicoRepository
     )
     {
        $this->middleware('auth:api', ['except' => []]);
     }

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/servico",
     *     summary="Cria um novo serviço",
     *     operationId="create",
     *     tags={"Servico"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"txt_servico_ser", "id_centro_custo_ser", "id_funcionario_servico_ser", "id_cliente_ser"},
     *             @OA\Property(property="txt_servico_ser", type="string", description="Descrição do serviço"),
     *             @OA\Property(property="id_centro_custo_ser", type="integer", description="ID do centro de custo"),
     *             @OA\Property(property="id_funcionario_servico_ser", type="integer", description="ID do funcionário responsável pelo serviço"),
     *             @OA\Property(property="id_cliente_ser", type="integer", description="ID do cliente"),
     *             @OA\Property(property="tipos_servico", type="array", @OA\Items(type="object", @OA\Property(property="id_servico_tipo_stp", type="integer"))),
     *             @OA\Property(property="materiais", type="array", @OA\Items(type="object", @OA\Property(property="id_material_mte", type="integer"))),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Serviço criado com sucesso",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string"), @OA\Property(property="service", ref="#/components/schemas/Servico"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na validação dos dados"
     *     )
     * )
     */
    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'txt_servico_ser'               => 'string|max:255',
            // 'vlr_servico_ser'               => 'required|integer',
            // 'dta_agendamento_ser'           => 'required|date_format:Y-m-d H:i:s',
            'id_centro_custo_ser'           => 'required|integer',
            'id_funcionario_servico_ser'    => 'required|integer',
            'id_cliente_ser'                => 'required|integer',
            'id_metodo_pagamento_ser'       => 'required|integer',
        ]);

        $servico = Servico::create([
            'txt_servico_ser'               => $request->txt_servico_ser,
            'id_metodo_pagamento_ser'       => $request->id_metodo_pagamento_ser,
            // 'vlr_servico_ser'               => $request->vlr_servico_ser,
            'dta_agendamento_ser'           => date('Y-m-d H:i'),
            'id_centro_custo_ser'           => $request->id_centro_custo_ser,
            'id_funcionario_servico_ser'    => $request->id_funcionario_servico_ser,
            'id_cliente_ser'                => $request->id_cliente_ser,
            'is_ativo_ser'                  => 1,
            'id_empresa_ser'                => $id_empresa,
        ]);

        foreach ($request->tipos_servico as $tipo_servico) {
            if (isset($tipo_servico['vlr_tipo_servico_rst'])) {
                $value = $tipo_servico['vlr_tipo_servico_rst'];
            } else {
                $value = ServicoTipo::select(['vlr_servico_tipo_stp'])->where('id_servico_tipo_stp', $tipo_servico['id_servico_tipo_stp'])->get()[0]->vlr_servico_tipo_stp;
            }

            RelServicoTipoServico::create([
                'id_servico_rst'                    => $servico->id,
                'id_tipo_servico_rst'               => $tipo_servico['id_servico_tipo_stp'],
                'vlr_tipo_servico_rst'              => $value
            ]);
        }

        foreach ($request->materiais as $material) {
            if (isset($material['vlr_material_rsm'])) {
                $valueMaterial = $material['vlr_material_rsm'];
            } else {
                $valueMaterial = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['id_material_mte'])->get()[0]->vlr_material_mte;
            }

            $valueQtdMaterial = 1;
            if (isset($material['qtd_material_rsm'])) {
                $valueQtdMaterial = $material['qtd_material_rsm'];
            }

            RelServicoMaterial::create([
                'id_servico_rsm'                    => $servico->id,
                'id_material_rsm'                   => $material['id_material_mte'],
                'vlr_material_rsm'                  => $valueQtdMaterial * $valueMaterial,
                'qtd_material_rsm'                  => $valueQtdMaterial
            ]);
        }

        return response()->json([
            'message' => 'Serviço criado com sucesso',
            'service' => $servico
        ]);
    }

    /**
     * @OA\Get(
     *     path="/servico/{id_servico}",
     *     summary="Obtém os detalhes de um serviço",
     *     operationId="get",
     *     tags={"Servico"},
     *     @OA\Parameter(
     *         name="id_servico",
     *         in="path",
     *         required=true,
     *         description="ID do serviço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do serviço",
     *         @OA\JsonContent(ref="#/components/schemas/Servico")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Serviço não encontrado"
     *     )
     * )
     */
    public function get(Request $request, $id_servico = null)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $Servico = new Servico();
        $filter = $request->only($Servico->getFillable());

        $filter = array_filter($filter, function($reg){ return mb_strtoupper($reg) != "NULL";});
        $data = Servico::get($id_empresa, $id_servico,$filter);

        $input_array = $data->toArray();

        $data = $this->groupServiceByTypeServiceAndMaterial($input_array);


        // return $data;
        return response()->json($data);
    }

    public function getLast30Days(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $data = Servico::getLast30Days($id_empresa, $request);
        return response()->json($data);
    }

    public function getLast30DaysPerFunc(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $data = Servico::getLast30DaysPerFunc($id_empresa, $request);
        return response()->json($data);
    }
    public function getLast30DaysPerTipoServico(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $data = Servico::getLast30DaysPerTipoServico($id_empresa, $request);
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/servico/{id_servico}",
     *     summary="Atualiza um serviço existente",
     *     operationId="update",
     *     tags={"Servico"},
     *     @OA\Parameter(
     *         name="id_servico",
     *         in="path",
     *         required=true,
     *         description="ID do serviço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Servico")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Serviço atualizado com sucesso",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na validação dos dados"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Serviço não encontrado"
     *     )
     * )
     */
    public function update(Int $id_servico, Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'txt_servico_ser'               => 'string|max:255',
            // 'vlr_servico_ser'               => 'integer',
            // 'dta_agendamento_ser'           => 'date_format:Y-m-d H:i:s',
            'id_centro_custo_ser'           => 'integer',
            'id_funcionario_servico_ser'    => 'integer',
            'id_cliente_ser'                => 'integer',
        ]);

        $data = $request->only(['txt_servico_ser', 'vlr_servico_ser', 'dta_agendamento_ser', 'id_centro_custo_ser', 'id_funcionario_servico_ser', 'id_cliente_ser']);
        $servico = Servico::updateReg($id_empresa, $id_servico, $data);

        $serviceData = Servico::get($id_empresa, $id_servico);

        $input_array = $serviceData->toArray();

        if($request->tipos_servico || $request->materiais){
            $serviceData = $this->groupServiceByTypeServiceAndMaterial($input_array);

            if($request->tipos_servico){
                $tipoServicoRemove = [];
                $tipoServicoUpdate = [];
                $tipoServicoNew = [];
                $tipoServicoAlreadyRegistered = $serviceData[0]['tipos_servico'];
                foreach ($tipoServicoAlreadyRegistered as $key => $old) {
                    $exists = false;
                    foreach ($request->tipos_servico as $key => $new) {
                        if($old['id_servico_tipo_stp'] == $new['id_servico_tipo_stp']){
                            if($old['vlr_tipo_servico_rst'] != $new['vlr_tipo_servico_rst']){
                                $tipoServicoUpdate []=$new;
                            }
                            $exists = true;
                            break;
                        }

                    }
                    if($exists == false){
                        $tipoServicoRemove []=$old;
                    }
                }

                $tipoServicoNew = array_filter($request->tipos_servico, function($reg) use ($tipoServicoAlreadyRegistered) {
                    foreach ($tipoServicoAlreadyRegistered as $value){
                        if($value['id_servico_tipo_stp'] == $reg['id_servico_tipo_stp'])
                            return false;
                    }
                    return true;
                });



                foreach ($tipoServicoNew as $tipo_servico) {
                    if (isset($tipo_servico['vlr_tipo_servico_rst'])) {
                        $value = $tipo_servico['vlr_tipo_servico_rst'];
                    } else {
                        $value = ServicoTipo::
                        select(['vlr_servico_tipo_stp'])
                        ->where('id_servico_tipo_stp', $tipo_servico['id_servico_tipo_stp'])
                        ->where('id_empresa_stp', $id_empresa)
                        ->get()[0]->vlr_servico_tipo_stp;
                    }

                    RelServicoTipoServico::create([
                        'id_servico_rst'                    => $id_servico,
                        'id_tipo_servico_rst'               => $tipo_servico['id_servico_tipo_stp'],
                        'vlr_tipo_servico_rst'              => $value
                    ]);
                }
                foreach ($tipoServicoUpdate as $tipo_servico) {
                    if (isset($tipo_servico['vlr_tipo_servico_rst'])) {
                        $value = $tipo_servico['vlr_tipo_servico_rst'];
                    } else {
                        $value = ServicoTipo::
                        select(['vlr_servico_tipo_stp'])
                        ->where('id_empresa_stp', $id_empresa)
                        ->where('id_servico_tipo_stp', $tipo_servico['id_servico_tipo_stp'])
                        ->get()[0]->vlr_servico_tipo_stp;
                    }

                    RelServicoTipoServico::where('id_servico_rst', $id_servico)
                    ->where('id_tipo_servico_rst', $tipo_servico['id_servico_tipo_stp'])
                    ->update([
                        'vlr_tipo_servico_rst'              => $value
                    ]);
                }

                foreach ($tipoServicoRemove as $tipo_servico) {
                    RelServicoTipoServico::where('id_servico_rst', $id_servico)
                    ->where('id_tipo_servico_rst', $tipo_servico['id_servico_tipo_stp'])
                    ->delete();
                }
            }

            if($request->materiais){
                $materialRemove = [];
                $materialUpdate = [];
                $materialNew = [];
                $materialAlreadyRegistered = $serviceData[0]['materiais'];
                foreach ($materialAlreadyRegistered as $key => $old) {
                    $exists = false;
                    foreach ($request->materiais as $key => $new) {
                        if($old['id_material_mte'] == $new['id_material_mte']){
                            if($old['vlr_material_rsm'] != $new['vlr_material_rsm'] || $old['qtd_material_rsm'] != $new['qtd_material_rsm']){
                                $materialUpdate []=$new;
                            }
                            $exists = true;
                            break;
                        }

                    }
                    if($exists == false){
                        $materialRemove []=$old;
                    }
                }

                $materialNew = array_filter($request->materiais, function($reg) use ($materialAlreadyRegistered) {
                    foreach ($materialAlreadyRegistered as $value){
                        if($value['id_material_mte'] == $reg['id_material_mte'])
                            return false;
                    }
                    return true;
                });

                // novos
                foreach ($materialNew as $material) {
                    if (isset($material['vlr_material_rsm'])) {
                        $valueMaterial = $material['vlr_material_rsm'];
                    } else {
                        $valueMaterial = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['id_material_mte'])->get()[0]->vlr_material_mte;
                    }

                    $valueQtdMaterial = 1;
                    if (isset($material['qtd_material_rsm'])) {
                        $valueQtdMaterial = $material['qtd_material_rsm'];
                    }

                    RelServicoMaterial::create([
                        'id_servico_rsm'                    => $id_servico,
                        'id_material_rsm'                   => $material['id_material_mte'],
                        'vlr_material_rsm'                  => $valueQtdMaterial * $valueMaterial,
                        'qtd_material_rsm'                  => $valueQtdMaterial
                    ]);
                }

                // update
                foreach ($materialUpdate as $material) {
                    if (isset($material['vlr_material_rsm'])) {
                        $valueMaterial = $material['vlr_material_rsm'];
                    } else {
                        $valueMaterial = Material::select(['vlr_material_mte'])->where('id_material_mte', $material['id_material_mte'])->get()[0]->vlr_material_mte;
                    }

                    $valueQtdMaterial = 1;
                    if (isset($material['qtd_material_rsm'])) {
                        $valueQtdMaterial = $material['qtd_material_rsm'];
                    }

                    RelServicoMaterial::where('id_servico_rsm', $id_servico)
                    ->where('id_material_rsm', $material['id_material_mte'])
                    ->update([
                        'vlr_material_rsm'                  => $valueQtdMaterial * $valueMaterial,
                        'qtd_material_rsm'                  => $valueQtdMaterial
                    ]);
                }

                // delete
                foreach ($materialRemove as $material) {
                    RelServicoMaterial::where('id_servico_rsm', $id_servico)
                    ->where('id_material_rsm', $material['id_material_mte'])
                    ->delete();
                }
            }
        }

        return response()->json([
            'message' => 'Serviço atualizado com sucesso'
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/servico/{id_servico}",
     *     summary="Finaliza um serviço",
     *     operationId="finalizar",
     *     tags={"Servico"},
     *     @OA\Parameter(
     *         name="id_servico",
     *         in="path",
     *         required=true,
     *         description="ID do serviço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Serviço finalizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Serviço não encontrado"
     *     )
     * )
     */
    public function finalizar(Request $request, Int $id_servico) {
        $id_empresa = $this->getIdEmpresa($request);

        Servico::finalizarReg($id_empresa, $id_servico);
    }

     /**
     * @OA\Delete(
     *     path="/servico/{id_servico}",
     *     summary="Exclui um serviço",
     *     operationId="delete",
     *     tags={"Servico"},
     *     @OA\Parameter(
     *         name="id_servico",
     *         in="path",
     *         required=true,
     *         description="ID do serviço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Serviço excluído com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Serviço não encontrado"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_servico) {
        $id_empresa = $this->getIdEmpresa($request);

        Servico::deleteReg($id_empresa, $id_servico);
    }


    private function groupServiceByTypeServiceAndMaterial($input_array){
        // variavel de saida
        $output_array = [];

        // agrupa materiais e tipos de servico por servico
        foreach ($input_array as $item) {
            $id = $item['id_servico_ser'];
            if (!isset($output_array[$id])) {
                $output_array[$id] = [...$item,
                    'materiais' => [],
                    'tipos_servico' => [],
                ];
                unset($output_array[$id]['id_material_mte']);
                unset($output_array[$id]['des_material_mte']);
                unset($output_array[$id]['des_reduz_unidade_und']);
                unset($output_array[$id]['vlr_material_rsm']);
                unset($output_array[$id]['qtd_material_rsm']);
                unset($output_array[$id]['id_servico_tipo_stp']);
                unset($output_array[$id]['des_servico_tipo_stp']);
                unset($output_array[$id]['vlr_tipo_servico_rst']);

                $output_array[$id]['vlr_servico_ser'] = 0;
            }

            if ($item['id_material_mte'] !== null) {
                $temp = array_filter($output_array[$id]['materiais'], function ($reg) use($item) { return $reg['id_material_mte'] == $item['id_material_mte']; });
                if(count($temp) == 0) {
                    $output_array[$id]['materiais'][] = [
                        "id_material_mte" => $item['id_material_mte'],
                        "des_material_mte" => $item['des_material_mte'],
                        "des_reduz_unidade_und" => $item['des_reduz_unidade_und'],
                        "vlr_material_rsm" => $item['vlr_material_rsm'],
                        "qtd_material_rsm" => $item['qtd_material_rsm']
                    ];
                    $output_array[$id]['vlr_servico_ser'] +=$item['vlr_material_rsm'];
                }
            }
            if ($item['id_servico_tipo_stp'] !== null) {
                $temp = array_filter($output_array[$id]['tipos_servico'], function ($reg) use($item) { return $reg['id_servico_tipo_stp'] == $item['id_servico_tipo_stp']; });
                if(count($temp) == 0) {
                    $output_array[$id]['tipos_servico'][] = [
                        "id_servico_tipo_stp" => $item['id_servico_tipo_stp'],
                        "des_servico_tipo_stp" => $item['des_servico_tipo_stp'],
                        "vlr_tipo_servico_rst" => $item['vlr_tipo_servico_rst']
                    ];
                    $output_array[$id]['vlr_servico_ser'] +=$item['vlr_tipo_servico_rst'];
                }
            }
        }

        // Converte o array associativo em um array indexado
        $output_array = array_values($output_array);
        return $output_array;
    }

    /**
     * @OA\Get(
     *     path="/servico/dashboard",
     *     summary="Obtém os dados do dashboard",
     *     operationId="getDashboardDados",
     *     tags={"Servico"},
     *     @OA\Parameter(
     *         name="centros_custo",
     *         in="query",
     *         required=false,
     *         description="IDs dos centros de custo separados por vírgula",
     *         @OA\Schema(type="string", example="2,3")
     *     ),
     *     @OA\Parameter(
     *         name="data_inicio",
     *         in="query",
     *         required=false,
     *         description="Data de início para o filtro (formato: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", example="2025-04-14 00:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="data_fim",
     *         in="query",
     *         required=false,
     *         description="Data de fim para o filtro (formato: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", example="2025-04-16 23:59:59")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do dashboard",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="total_ativos", type="integer"),
     *                 @OA\Property(property="total_finalizados", type="integer"),
     *                 @OA\Property(property="total_inativos", type="integer"),
     *                 @OA\Property(property="media_tempo_atendimento", type="string", example="00:06:14")
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Serviço não encontrado"
     *     )
     * )
    */
    public function getDashboardDados(Request $request)
    {
        $centrosCusto = $request->input('centros_custo', []);
        $dataInicio   = $request->input('data_inicio');
        $dataFim      = $request->input('data_fim');

        $array_centro_custo = explode(',', $centrosCusto);

        $data = Servico::getDashboardDados($array_centro_custo, $dataInicio, $dataFim);
        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/servico/topSevenServiceTypes",
     *     summary="Obtém o top 7 tipos de serviço lançados em serviços",
     *     operationId="getTopSevenServiceTypes",
     *     tags={"Servico"},
     *     @OA\Parameter(
     *         name="centros_custo",
     *         in="query",
     *         required=false,
     *         description="IDs dos centros de custo separados por vírgula",
     *         @OA\Schema(type="string", example="1,2")
     *     ),
     *     @OA\Parameter(
     *         name="data_inicio",
     *         in="query",
     *         required=false,
     *         description="Data de início para o filtro (formato: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", example="2025-04-14 00:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="data_fim",
     *         in="query",
     *         required=false,
     *         description="Data de fim para o filtro (formato: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", example="2025-04-16 23:59:59")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados da consulta",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="tipo_servico", type="string", example="Corte de Cabelo"),
     *                 @OA\Property(property="total_tipo_servico", type="integer", example=42)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Serviço não encontrado"
     *     )
     * )
     */
    public function getTopSevenServiceTypes(Request $request)
    {
        $centrosCusto = explode(',', $request->query('centros_custo'));
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');

        $data = RelServicoTipoServico::getTopTiposServico($centrosCusto, $dataInicio, $dataFim);

        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/servico/topThreeEmployees",
     *     summary="Obtém o top 3 funcionarios por total de tipos de serviço lançados em serviços",
     *     operationId="getTopThreeEmployeesByTotalTypeService",
     *     tags={"Servico"},
     *     @OA\Parameter(
     *         name="centros_custo",
     *         in="query",
     *         required=false,
     *         description="IDs dos centros de custo separados por vírgula",
     *         @OA\Schema(type="string", example="1,2")
     *     ),
     *     @OA\Parameter(
     *         name="data_inicio",
     *         in="query",
     *         required=false,
     *         description="Data de início para o filtro (formato: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", example="2025-04-14 00:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="data_fim",
     *         in="query",
     *         required=false,
     *         description="Data de fim para o filtro (formato: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", example="2025-04-16 23:59:59")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados da consulta",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="nome", type="string", example="Corte de Cabelo"),
     *                 @OA\Property(property="total_tipos_servico", type="integer", example=42)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Serviço não encontrado"
     *     )
     * )
     */
    public function getTopThreeEmployeesByTotalTypeService(Request $request)
    {
        $centrosCusto = explode(',', $request->query('centros_custo'));
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');

        $data = $this->servicoRepository->getTopThreeEmployeesByTotalTypeService($request->query('limit', 3), $centrosCusto, $dataInicio, $dataFim);

        return response()->json($data);
    }

}
