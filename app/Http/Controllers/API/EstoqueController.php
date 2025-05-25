<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function __construct(
        private EstoqueRepositoryInterface $estoqueRepository
    ) {
    }

    public function getIdEmpresa(Request $request)
    {
        $id_empresa = (int) $request->header('id-empresa-d');

        return $id_empresa;
    }

    public function getIdUser(Request $request)
    {
        $id_usuario = (int) $request->header('id-usuario-d');

        return $id_usuario;
    }

    /**
     * @OA\Get(
     *     path="/estoque/{id_estoque}",
     *     summary="Obtém um estoque pelo ID",
     *     tags={"Estoque"},
     *     @OA\Parameter(
     *         name="id_estoque",
     *         in="path",
     *         required=true,
     *         description="ID do estoque",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estoque encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Estoque não encontrado"
     *     )
     * )
     */
    public function get(Request $request, int $id_estoque = null)
    {
        $id_empresa = $this->getIdEmpresa($request);
        $id_usuario = $this->getIdUser($request);

        if ($id_estoque) {
            $data = $this->estoqueRepository->getById($id_empresa, $id_estoque);
            $data_array = json_decode($data->content());

            if (empty($data_array)) {
                return response()->json([
                    'error' => 'Estoque Não Existe',
                ], 400);
            }
            return $data;
        }

        $queryParams = (object) [
            'perPage' => $request->query('per_page', 10),
            'filter' => $request->query('filter', ''),
            'pageNumber' => $request->query('page_number', 1),
            'id_centro_custo' => $request->query('id_centro_custo', null),
            'getByCompany' => filter_var($request->query('getByCompany', false), FILTER_VALIDATE_BOOLEAN),
        ];

        if ($queryParams->id_centro_custo === "null" || $queryParams->id_centro_custo === "") {
            $queryParams->id_centro_custo = null;
        }

        $queryParams->perPage = ($queryParams->perPage > 50) ? 50 : $queryParams->perPage;

        $result = $this->estoqueRepository->getAll($id_empresa, $id_usuario, $queryParams);

        $result_final = json_decode($result->getContent(), true);
        return $result_final;
    }

    /**
     * @OA\Post(
     *     path="/estoque",
     *     summary="Cria um novo estoque",
     *     tags={"Estoque"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Estoque criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_estoque_est' => 'required|string|max:255',
            'id_centro_custo_est' => 'required|integer|exists:tb_centro_custo,id_centro_custo_cco'
        ]);

        $estoque = $this->estoqueRepository->create($request->all(), $id_empresa);

        return response()->json($estoque, 201);
    }

    /**
     * @OA\Put(
     *     path="/estoque/{id_estoque}",
     *     summary="Atualiza um estoque",
     *     tags={"Estoque"},
     *     @OA\Parameter(
     *         name="id_estoque",
     *         in="path",
     *         required=true,
     *         description="ID do estoque",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estoque atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(int $id_estoque, Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_estoque_est' => 'required|string|max:255',
            'id_centro_custo_est' => 'required|integer|exists:tb_centro_custo,id_centro_custo_cco'
        ]);

        $estoque = $this->estoqueRepository->updateReg($id_empresa, $id_estoque, $request);

        return response()->json($estoque);
    }

    /**
     * @OA\Delete(
     *     path="/estoque/{id_estoque}",
     *     summary="Deleta um estoque",
     *     tags={"Estoque"},
     *     @OA\Parameter(
     *         name="id_estoque",
     *         in="path",
     *         required=true,
     *         description="ID do estoque",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estoque deletado com sucesso"
     *     )
     * )
     */
    public function delete(Request $request, int $id_estoque)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_estoque = $this->estoqueRepository->deleteReg($id_estoque, $id_empresa);

        return response()->json($inactive_estoque, 200);
    }

    /**
     * @OA\Get(
     *     path="/estoque/valores",
     *     summary="Obtém os estoques com valores e materiais associados",
     *     tags={"Estoque"},
     *     @OA\Response(
     *         response=200,
     *         description="Estoque com valores encontrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="estoque_id", type="integer"),
     *                 @OA\Property(property="estoque_descricao", type="string"),
     *                 @OA\Property(property="materiais", type="array", @OA\Items(
     *                     @OA\Property(property="material_descricao", type="string"),
     *                     @OA\Property(property="valor_unitario", type="number", format="float"),
     *                     @OA\Property(property="quantidade_em_estoque", type="number", format="float"),
     *                     @OA\Property(property="valor_total_em_estoque", type="number", format="float")
     *                 ))
     *             )
     *         )
     *     )
     * )
     */
    public function showEstoqueComValores(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);
        $id_usuario = $this->getIdUser($request);

        $dados = Estoque::getEstoqueComValores($id_usuario, $id_empresa);

        return response()->json($dados);
    }
}
