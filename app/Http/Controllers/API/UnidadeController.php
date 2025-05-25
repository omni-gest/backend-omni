<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\UnidadeRepositoryInterface;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function __construct(
        private UnidadeRepositoryInterface $unidadeRepository
     )
     {
     }

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/unidade",
     *     summary="Cria uma nova unidade",
     *     operationId="createUnidade",
     *     tags={"Unidade"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Unidade criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_unidade_und'       => 'required|string|max:255',
            'des_reduz_unidade_und' => 'required|string|max:255',
            'id_centro_custo_und'   => 'required|integer|',
        ]);
        $request = $request->merge(['id_empresa_und' => $id_empresa]);

        $unidade = $this->unidadeRepository->create($request->all());

        return response()->json($unidade,201);
    }

    /**
     * @OA\Get(
     *     path="/unidade/{id_unidade_und}",
     *     summary="Obtém uma unidade pelo ID",
     *     operationId="getUnidadeById",
     *     tags={"Unidade"},
     *     @OA\Parameter(
     *         name="id_unidade_und",
     *         in="path",
     *         required=true,
     *         description="ID da unidade",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unidade encontrada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Unidade não encontrada"
     *     )
     * )
     *
     * @OA\Get(
     *     path="/unidade",
     *     summary="Obtém todas as unidades",
     *     operationId="getAllUnidades",
     *     tags={"Unidade"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de unidades"
     *     )
     * )
     */
    public function get(Request $request, $id_unidade_und = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_unidade_und){
            $data = $this->unidadeRepository->getById($id_empresa, $id_unidade_und);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Unidade Não Existe',],400);
            }
            return $data;
        }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->unidadeRepository->getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    /**
     * @OA\Patch(
     *     path="/unidade/{id_unidade_und}",
     *     summary="Atualiza uma unidade",
     *     operationId="updateUnidade",
     *     tags={"Unidade"},
     *     @OA\Parameter(
     *         name="id_unidade_und",
     *         in="path",
     *         required=true,
     *         description="ID da unidade",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unidade atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Unidade não encontrada"
     *     )
     * )
     */
    public function update(Int $id_unidade_und, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_unidade_und'       => 'string|max:255',
            'des_reduz_unidade_und' => 'string|max:255',
            'id_centro_custo_und'   => 'integer',
        ]);
        $updated_unidade = $this->unidadeRepository->updateReg($id_empresa, $id_unidade_und, $request);

        return response()->json($updated_unidade, 200);
    }

    /**
     * @OA\Delete(
     *     path="/unidade/{id_unidade_und}",
     *     summary="Exclui (inativa) uma unidade",
     *     operationId="deleteUnidade",
     *     tags={"Unidade"},
     *     @OA\Parameter(
     *         name="id_unidade_und",
     *         in="path",
     *         required=true,
     *         description="ID da unidade",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unidade inativada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Unidade não encontrada"
     *     )
     * )
     */
    public function delete(Int $id_unidade_und, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_unidade = $this->unidadeRepository->deleteReg($id_empresa, $id_unidade_und);

        return response()->json($inactive_unidade, 200);
    }

}
