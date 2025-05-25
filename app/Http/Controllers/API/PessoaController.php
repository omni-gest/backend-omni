<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\PessoaRepositoryInterface;
use Illuminate\Http\Request;
use App\Helpers\ValidateString;

class PessoaController extends Controller
{

    public function __construct(
        private PessoaRepositoryInterface $pessoaRepository
     )
     {
     }

     public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/pessoa",
     *     summary="Cria uma nova pessoa",
     *     description="Cria uma nova pessoa com os dados fornecidos.",
     *     tags={"Pessoa"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"nome_pessoa_pes", "id_centro_custo_pes"},
     *                 @OA\Property(property="nome_pessoa_pes", type="string", description="Nome da pessoa"),
     *                 @OA\Property(property="id_centro_custo_pes", type="integer", description="ID do centro de custo"),
     *                 @OA\Property(property="documento_pessoa_pes", type="string", description="Documento de identificação")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pessoa criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(request $request){
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'nome_pessoa_pes'           => 'required|string|',
            'id_centro_custo_pes'       => 'required|integer|',
            'documento_pessoa_pes'      => 'string|',
        ]);

        $pessoa = $this->pessoaRepository->create($request->all(),$id_empresa);

        return response()->json($pessoa,201);
    }

    /**
     * @OA\Get(
     *     path="/pessoa/{id_pessoa}",
     *     summary="Retorna uma pessoa por ID",
     *     description="Retorna os detalhes de uma pessoa com base no ID fornecido.",
     *     tags={"Pessoa"},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da pessoa",
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Pessoa não encontrada"
     *     )
     * )
     */
    public function get(Request $request, $id_pessoa = null){
        $id_empresa = $this->getIdEmpresa($request);

        if($id_pessoa){
            $data = $this->pessoaRepository->getById($id_empresa,$id_pessoa);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'erro'=> 'Pessoa Não Existe'
                ],400);
            }
            return $data;
        }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->pessoaRepository->getAll($id_empresa, $filter, $per_page, $page_number);
        return $result;
    }

    /**
     * @OA\Put(
     *     path="/pessoa/{id_pessoa}",
     *     summary="Atualiza os dados de uma pessoa",
     *     description="Atualiza os dados de uma pessoa com base no ID fornecido.",
     *     tags={"Pessoa"},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="nome_pessoa_pes", type="string", description="Nome da pessoa"),
     *                 @OA\Property(property="id_centro_custo_pes", type="integer", description="ID do centro de custo"),
     *                 @OA\Property(property="documento_pessoa_pes", type="string", description="Documento de identificação")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pessoa atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação ou pessoa não encontrada"
     *     )
     * )
     */
    public function update(Request $request,Int $id_pessoa){
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'nome_pessoa_pes'           => 'string',
            'id_centro_custo_pes'       => 'integer',
            'documento_pessoa_pes'      => 'string',
        ]);
        $updated_pessoa = $this->pessoaRepository->updateReg($id_empresa, $id_pessoa, $request);

        return response()->json($updated_pessoa,200);
    }

    /**
     * @OA\Delete(
     *     path="/pessoa/{id_pessoa}",
     *     summary="Deleta uma pessoa",
     *     description="Deleta uma pessoa com base no ID fornecido.",
     *     tags={"Pessoa"},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pessoa deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Pessoa não encontrada"
     *     )
     * )
     */
    public function delete(Request $request,Int $id_pessoa){
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_pessoa = $this->pessoaRepository->deleteReg($id_empresa, $id_pessoa);

        return response()->json($inactive_pessoa,200);
    }
}
