<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ServicoTipoRepositoryInterface;
use Illuminate\Http\Request;

class ServicoTipoController extends Controller
{
    public function __construct(
        private ServicoTipoRepositoryInterface $servicoTipoRepository
     )
     {
     }

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/servicoTipo",
     *     summary="Cria um novo tipo de serviço",
     *     operationId="createServicoTipo",
     *     tags={"ServicoTipo"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"des_servico_tipo_stp", "vlr_servico_tipo_stp", "id_centro_custo_stp"},
     *             @OA\Property(property="des_servico_tipo_stp", type="string", example="Serviço Premium"),
     *             @OA\Property(property="vlr_servico_tipo_stp", type="integer", example=150),
     *             @OA\Property(property="id_centro_custo_stp", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tipo de serviço criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/ServicoTipo")
     *     ),
     *     @OA\Response(response=400, description="Dados inválidos"),
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255',
            'vlr_servico_tipo_stp' => 'required|string|max:255',
            'id_centro_custo_stp'  => 'required|integer|',
        ]);

        $request = $request->merge(['id_empresa_stp' => $id_empresa]);
        $servico_tipo = $this->servicoTipoRepository->create($request->all());

        return response()->json($servico_tipo,201);
    }

    /**
     * @OA\Get(
     *     path="/servicoTipo/{id_servico_tipo}",
     *     summary="Obtém um tipo de serviço pelo ID",
     *     operationId="getServicoTipo",
     *     tags={"ServicoTipo"},
     *     @OA\Parameter(
     *         name="id_servico_tipo",
     *         in="path",
     *         required=true,
     *         description="ID do tipo de serviço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do tipo de serviço",
     *         @OA\JsonContent(ref="#/components/schemas/ServicoTipo")
     *     ),
     *     @OA\Response(response=400, description="Tipo de serviço não encontrado"),
     * )
     */
    public function get(Request $request, $id_servico_tipo = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_servico_tipo){
            $data = $this->servicoTipoRepository->getById($id_empresa, $id_servico_tipo);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Tip de Serviço Não Existe',],400);
            }
            return $data;
        }

        $queryParams = (object) [
            'perPage' => $request->query('per_page', 10),
            'filter' => $request->query('filter', ''),
            'pageNumber' => $request->query('page_number', 1),
            'id_centro_custo_stp' => $request->query('id_centro_custo_stp', null),
        ];

        $queryParams->perPage = ($queryParams->perPage > 50) ? 50 : $queryParams->perPage;

        $result = $this->servicoTipoRepository->getAll($id_empresa, $queryParams);
        return $result;
    }

    /**
     * @OA\Put(
     *     path="/servicoTipo/{id_servico_tipo}",
     *     summary="Atualiza um tipo de serviço",
     *     operationId="updateServicoTipo",
     *     tags={"ServicoTipo"},
     *     @OA\Parameter(
     *         name="id_servico_tipo",
     *         in="path",
     *         required=true,
     *         description="ID do tipo de serviço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"des_servico_tipo_stp", "vlr_servico_tipo_stp"},
     *             @OA\Property(property="des_servico_tipo_stp", type="string", example="Serviço Atualizado"),
     *             @OA\Property(property="vlr_servico_tipo_stp", type="integer", example=200),
     *             @OA\Property(property="id_centro_custo_stp", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Tipo de serviço atualizado"),
     *     @OA\Response(response=400, description="Erro na atualização"),
     * )
     */
    public function update(Int $id_servico_tipo, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_servico_tipo_stp' => 'required|string|max:255',
            'vlr_servico_tipo_stp' => 'required|string|max:255',
            'id_centro_custo_stp'  => 'integer',
        ]);

        $updated_servicoTipo = $this->servicoTipoRepository->updateReg($id_empresa, $id_servico_tipo, $request);

        return response()->json($updated_servicoTipo,200);
    }

    /**
     * @OA\Delete(
     *     path="/servicoTipo/{id_servico_tipo}",
     *     summary="Inativa um tipo de serviço",
     *     operationId="deleteServicoTipo",
     *     tags={"ServicoTipo"},
     *     @OA\Parameter(
     *         name="id_servico_tipo",
     *         in="path",
     *         required=true,
     *         description="ID do tipo de serviço",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Tipo de serviço inativado"),
     *     @OA\Response(response=400, description="Erro ao inativar"),
     * )
     */
    public function delete(Int $id_servico_tipo, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_servicoTipo = $this->servicoTipoRepository->deleteReg($id_empresa, $id_servico_tipo);

        return response()->json($inactive_servicoTipo,200);
    }
}

