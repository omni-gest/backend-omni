<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\EstoqueItemRepositoryInterface;
use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstoqueItemController extends Controller
{
    public function __construct(
        private EstoqueItemRepositoryInterface $estoqueItemRepository
    ) {
    }

    public function getIdEmpresa(Request $request)
    {
        $id_empresa = (int) $request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Get(
     *     path="/estoqueItem",
     *     summary="Lista todos os estoques",
     *     tags={"Estoque"},
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
     *         description="Filtro para buscar estoque",
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
     *         description="Lista de estoque retornada com sucesso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Estoque"))
     *     )
     * )
     */

    public function get(Request $request, $id_estoque = null)
    {
        $id_empresa = $this->getIdEmpresa($request);

        if ($id_estoque) {
            $data = $this->estoqueItemRepository->getById($id_empresa, $id_estoque);
            $data_array = json_decode($data->content());

            if (empty($data_array)) {
                return response()->json([
                    'error' => 'Estoque Item Não Existe',
                ], 400);
            }
            return $data;
        }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->estoqueItemRepository->getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    /**
     * @OA\Post(
     *     path="/estoqueItem",
     *     summary="Cria um novo estoque",
     *     tags={"Estoque"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"des_estoque_item_eti", 
     *                        "id_centro_custo_eti",
     *                        "id_material_eti",
     *                        "id_empresa_eti",
     *                        "qtd_estoque_item_eti",
     *                        "id_estoque_eti"},
     *             @OA\Property(property="des_estoque_item_eti", type="string"),
     *             @OA\Property(property="id_centro_custo_eti", type="integer"),
     *             @OA\Property(property="id_material_eti", type="integer"),
     *             @OA\Property(property="id_empresa_eti", type="integer"),
     *             @OA\Property(property="qtd_estoque_item_eti", type="integer"),
     *             @OA\Property(property="id_estoque_eti", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Estoque criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Estoque")
     *     )
     * )
     */
    
    public function create(Request $request)
    {
        $request_formatted = current((array) $request->request);

        $validator = Validator::make(($request_formatted), [
            'des_estoque_item_eti' => 'required|string|max:255',
            'id_centro_custo_eti' => 'required|integer|exists:tb_centro_custo,id_centro_custo_cco'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id_empresa = $this->getIdEmpresa($request);

        $estoque = $this->estoqueItemRepository->getByEstoqueMaterial($request->id_centro_custo_eti, $request->id_material_eti);

        if ($estoque) {
            return response()->json([
                'message' => 'Estoque já existe para o centro de custo e material informados, realize uma baixa de entrada ou saída para atualizar o saldo',
            ], 422);
        }

        $estoque = $this->estoqueItemRepository->create($request->all(), $id_empresa);

        return response()->json($estoque, 201);
    }

    /**
     * @OA\Put(
     *     path="/estoqueItem/{id_estoque_item}",
     *     summary="Atualiza um estoque",
     *     tags={"Estoque"},
     *     @OA\Parameter(
     *         name="id_estoque_item",
     *         in="path",
     *         required=true,
     *         description="ID do estoque item",
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
    public function update(int $id_estoque_item, Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'des_estoque_item_eti' => 'required|string|max:255',
            'id_centro_custo_eti' => 'required|integer|exists:tb_centro_custo,id_centro_custo_cco'
        ]);

        $estoque = $this->estoqueItemRepository->updateReg($id_empresa, $id_estoque_item, $request);

        return response()->json($estoque);
    }

    /**
     * @OA\Delete(
     *     path="/estoque/{id_estoque_item}",
     *     summary="Deleta um estoque daquele produto",
     *     tags={"Estoque"},
     *     @OA\Parameter(
     *         name="id_estoque_item",
     *         in="path",
     *         required=true,
     *         description="ID do estoque item",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estoque Item deletado com sucesso"
     *     )
     * )
     */
    public function delete(Request $request, int $id_estoque_item)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_estoque_item = $this->estoqueItemRepository->deleteReg($id_estoque_item, $id_empresa);

        return response()->json($inactive_estoque_item, 200);
    }

}
