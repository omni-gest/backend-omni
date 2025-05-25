<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CentroCustoRepositoryInterface;
use Illuminate\Http\Request;

class CentroCustoController extends Controller
{
    public function __construct(
        private CentroCustoRepositoryInterface $centroCustoRepository
     )
     {
     }


     public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function getIdUsuario(Request $request) {
        $id_usuario = (int)$request->header('id-usuario-d');

        return $id_usuario;
    }

    /**
     * @OA\Post(
     *     path="/centroCusto",
     *     summary="Cria um novo centro de custo",
     *     tags={"CentroCusto"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"des_centro_custo_cco"},
     *             @OA\Property(property="des_centro_custo_cco", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Centro de Custo criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/CentroCusto")
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_centro_custo_cco' => 'required|string|max:255'
        ]);
        $request = $request->merge(['id_empresa_cco' => $id_empresa]);
        $centro_custo = $this->centroCustoRepository->create($request->all());

        return response()->json($centro_custo,201);
    }

    /**
     * @OA\Get(
     *     path="/centroCusto",
     *     summary="Lista todos os centros de custo",
     *     tags={"CentroCusto"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Quantidade de itens por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Filtro para buscar centros de custo",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page_number",
     *         in="query",
     *         description="Número da página",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de centros de custo retornada com sucesso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CentroCusto"))
     *     )
     * )
     */
    public function get(Request $request, $id_centro_custo = null) {
        $id_usuario = $this->getIdUsuario($request);
        $id_empresa = $this->getIdEmpresa($request);
        $getByCompany = filter_var($request->query('getByCompany', false), FILTER_VALIDATE_BOOLEAN);
        if($id_centro_custo){
            $data = $this->centroCustoRepository->getById($id_usuario, $id_centro_custo);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Centro de Custo Não Existe',],400);
            }
            return $data;
        }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->centroCustoRepository->getAll($id_usuario, $filter, $per_page, $page_number, $id_empresa, $getByCompany);

        return $result;
    }

    /**
     * @OA\Put(
     *     path="/centroCusto/{id_centro_custo}",
     *     summary="Atualiza um centro de custo existente",
     *     tags={"CentroCusto"},
     *     @OA\Parameter(
     *         name="id_centro_custo",
     *         in="path",
     *         description="ID do centro de custo a ser atualizado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"des_centro_custo_cco"},
     *             @OA\Property(property="des_centro_custo_cco", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Centro de Custo atualizado com sucesso"
     *     )
     * )
     */
    public function update(Int $id_centro_custo, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_centro_custo_cco' => 'required|string|max:255'
        ]);

        $updated_centroCusto = $this->centroCustoRepository->updateReg($id_empresa, $id_centro_custo, $request);

        return response()->json($updated_centroCusto,200);
    }

    /**
     * @OA\Delete(
     *     path="/centroCusto/{id_centro_custo}",
     *     summary="Remove um centro de custo",
     *     tags={"CentroCusto"},
     *     @OA\Parameter(
     *         name="id_centro_custo",
     *         in="path",
     *         description="ID do centro de custo a ser removido",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Centro de Custo removido com sucesso"
     *     )
     * )
     */
    public function delete(Int $id_centro_custo, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_centroCusto = $this->centroCustoRepository->deleteReg($id_empresa, $id_centro_custo);

        return response()->json($inactive_centroCusto,200);
    }
}
