<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\MaterialRepositoryInterface;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class MaterialController extends Controller
{

    public function __construct(
        private MaterialRepositoryInterface $materialRepository
     )
     {
        $this->middleware('auth:api', ['except' => []]);
     }


    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Get(
     *     path="/material/{id_material}",
     *     summary="Obter material por ID",
     *     description="Retorna os detalhes de um material específico",
     *     operationId="getMaterialById",
     *     tags={"Material"},
     *     @OA\Parameter(
     *         name="id_material",
     *         in="path",
     *         required=true,
     *         description="ID do material",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do material",
     *         @OA\JsonContent(ref="#/components/schemas/Material")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Material não encontrado"
     *     )
     * )
     */
    public function get(Request $request, Int $id_material = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_material){
            $data = $this->materialRepository->getById($id_empresa, $id_material);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Material Não Existe',],400);
            }
            return $data;
        }

        $queryParams = (object) [
            'perPage' => $request->query('per_page', 10),
            'filter' => $request->query('filter', ''),
            'id_estoque' => $request->query('id_estoque', null),
            'pageNumber' => $request->query('page_number', 1),
            'id_centro_custo_mte' => $request->query('id_centro_custo_mte', null),
            'verificar_estoque' => filter_var($request->query('verificarEstoque', false), FILTER_VALIDATE_BOOLEAN),
        ];

       if ($queryParams->id_centro_custo_mte === "null" || $queryParams->id_centro_custo_mte === "") {
            $queryParams->id_centro_custo_mte = null;
        }

        $queryParams->perPage = ($queryParams->perPage > 50) ? 50 : $queryParams->perPage;


        $result = $this->materialRepository->getAll($id_empresa, $queryParams);
        return $result;
    }

    /**
     * @OA\Post(
     *     path="/material",
     *     summary="Criar material",
     *     description="Cria um novo material",
     *     operationId="createMaterial",
     *     tags={"Material"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="id_unidade_mte", type="integer", description="ID da unidade"),
     *                 @OA\Property(property="des_material_mte", type="string", description="Descrição do material"),
     *                 @OA\Property(property="vlr_material_mte", type="integer", description="Valor do material"),
     *                 @OA\Property(property="id_centro_custo_mte", type="integer", description="ID do centro de custo")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Material criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Material")
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'id_unidade_mte'        => 'required|integer',
            'des_material_mte'      => 'required|string|max:255',
            'vlr_material_mte'      => 'required|numeric',
            'id_centro_custo_mte'   => 'required|integer|',
        ]);

        $request = $request->merge(['id_empresa_mte' => $id_empresa]);

        $material = $this->materialRepository->create($request->all());

        return response()->json($material,200);
    }

    /**
     * @OA\Put(
     *     path="/material/{id_material}",
     *     summary="Atualizar material",
     *     description="Atualiza os dados de um material",
     *     operationId="updateMaterial",
     *     tags={"Material"},
     *     @OA\Parameter(
     *         name="id_material",
     *         in="path",
     *         required=true,
     *         description="ID do material",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="id_unidade_mte", type="integer", description="ID da unidade"),
     *                 @OA\Property(property="des_material_mte", type="string", description="Descrição do material"),
     *                 @OA\Property(property="vlr_material_mte", type="integer", description="Valor do material"),
     *                 @OA\Property(property="id_centro_custo_mte", type="integer", description="ID do centro de custo")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Material atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Material")
     *     )
     * )
     */
    public function update(Int $id_material, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'id_unidade_mte'        => 'integer',
            'des_material_mte'      => 'string|max:255',
            'id_centro_custo_mte'   => 'integer',
            'vlr_material_mte'      => 'numeric'
        ]);

        $updated_material = $this->materialRepository->updateReg($id_empresa, $id_material, $request);

        return response()->json($updated_material, 200);
    }

    /**
     * @OA\Delete(
     *     path="/material/{id_material}",
     *     summary="Excluir material",
     *     description="Desativa um material",
     *     operationId="deleteMaterial",
     *     tags={"Material"},
     *     @OA\Parameter(
     *         name="id_material",
     *         in="path",
     *         required=true,
     *         description="ID do material",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Material excluído com sucesso"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_material) {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_material = $this->materialRepository->deleteReg($id_empresa, $id_material);

        return response()->json($inactive_material,200);
    }
}
