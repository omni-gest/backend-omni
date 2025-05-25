<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\FornecedorRepositoryInterface;
use Illuminate\Http\Request;
use App\Helpers\ValidateString;

class FornecedorController extends Controller
{
    public function __construct(
        private FornecedorRepositoryInterface $fornecedorRepository
     )
     {
     }

     public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

     /**
     * @OA\Post(
     *     path="/fornecedor",
     *     summary="Cria um novo fornecedor",
     *     tags={"Fornecedor"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Fornecedor")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Fornecedor criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Fornecedor")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request){
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_fornecedor_frn'      => 'required|string|max:255',
            'tel_fornecedor_frn'       => 'required|string|max:15',
            'documento_fornecedor_frn' => 'string|max:18',
        ]);

        $request = $request->merge(['id_empresa_frn' => $id_empresa,]);
        $fornecedor = $this->fornecedorRepository->create($request);
        return response()->json($fornecedor, 201);
    }

    /**
     * @OA\Get(
     *     path="/fornecedor/{id_fornecedor}",
     *     summary="Obtém um fornecedor pelo ID",
     *     tags={"Fornecedor"},
     *     @OA\Parameter(
     *         name="id_fornecedor",
     *         in="path",
     *         description="ID do fornecedor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Fornecedor")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Fornecedor não encontrado"
     *     )
     * )
     */
    public function get(Request $request, $id_fornecedor = null){
        $id_empresa = $this->getIdEmpresa($request);

        if($id_fornecedor){
            $data = $this->fornecedorRepository->getById($id_empresa, $id_fornecedor);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Fornecedor Não Existe'], 400);
            }
            return $data;
        }
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->fornecedorRepository->getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    /**
     * @OA\Put(
     *     path="/fornecedor/{id_fornecedor}",
     *     summary="Atualiza um fornecedor",
     *     tags={"Fornecedor"},
     *     @OA\Parameter(
     *         name="id_fornecedor",
     *         in="path",
     *         required=true,
     *         description="ID do fornecedor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Fornecedor")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(Int $id_fornecedor, Request $request){
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_fornecedor_frn'      => 'string|max:255',
            'tel_fornecedor_frn'       => 'string|max:15',
            'documento_fornecedor_frn' => 'string|max:18',
        ]);

        $updated_fornecedor = $this->fornecedorRepository->updateReg($id_fornecedor, $id_empresa, $request);

        return response()->json($updated_fornecedor, 200);
    }

    /**
     * @OA\Delete(
     *     path="/fornecedor/{id_fornecedor}",
     *     summary="Deleta um fornecedor",
     *     tags={"Fornecedor"},
     *     @OA\Parameter(
     *         name="id_fornecedor",
     *         in="path",
     *         required=true,
     *         description="ID do fornecedor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor deletado com sucesso"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_fornecedor) {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_fornecedor = $this->fornecedorRepository->deleteReg($id_empresa, $id_fornecedor);

        return response()->json($inactive_fornecedor, 200);
    }
}
