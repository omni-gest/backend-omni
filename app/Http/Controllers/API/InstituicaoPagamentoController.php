<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\InstituicaoPagamentoRepositoryInterface;
use Illuminate\Http\Request;
class InstituicaoPagamentoController extends Controller
{

    public function __construct(
        private InstituicaoPagamentoRepositoryInterface $instituicaoPagamentoRepository
     )
     {
     }

     public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Get(
     *     path="/instituicaoPagamento/{id_instituicao_pagamento}",
     *     summary="Recuperar uma Instituicao de Pagamento",
     *     tags={"InstituicaoPagamento"},
     *     @OA\Parameter(
     *         name="id_instituicao_pagamento",
     *         in="path",
     *         description="ID da Instituicao de Pagamento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados da Instituicao de Pagamento",
     *         @OA\JsonContent(ref="#/components/schemas/InstituicaoPagamento")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Instituicao de Pagamento não encontrada"
     *     )
     * )
     */
    public function get(Request $request, $id_instituicao_pagamento = null) {
        $id_empresa = $this->getIdEmpresa($request);
        if($id_instituicao_pagamento){
            $data = $this->instituicaoPagamentoRepository->getById($id_empresa, $id_instituicao_pagamento);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Instituicao de Pagamento Não Existe',],400);
            }
            return $data;
        }
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->instituicaoPagamentoRepository->getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    /**
     * @OA\Post(
     *     path="/instituicaoPagamento",
     *     summary="Criar uma nova Instituicao de Pagamento",
     *     tags={"InstituicaoPagamento"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"desc_instituicao_pagamento_tip"},
     *                 @OA\Property(property="desc_instituicao_pagamento_tip", type="string", description="Descrição da instituição de pagamento")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Instituicao de Pagamento criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/InstituicaoPagamento")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na criação da Instituicao de Pagamento"
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_instituicao_pagamento_tip' => 'required|string|max:255'
        ]);

        $request = $request->merge(['id_empresa_tip' => $id_empresa,]);
        $instituicaoPagamento = $this->instituicaoPagamentoRepository->create($request->all());

        return response()->json($instituicaoPagamento, 201);
    }

    /**
     * @OA\Put(
     *     path="/instituicaoPagamento/{id_instituicao_pagamento}",
     *     summary="Atualizar uma Instituicao de Pagamento",
     *     tags={"InstituicaoPagamento"},
     *     @OA\Parameter(
     *         name="id_instituicao_pagamento",
     *         in="path",
     *         description="ID da Instituicao de Pagamento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="desc_instituicao_pagamento_tip", type="string", description="Descrição da instituição de pagamento")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Instituicao de Pagamento atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao atualizar a Instituicao de Pagamento"
     *     )
     * )
     */
    public function update(Int $id_instituicao_pagamento, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);
        $request->validate([
            'desc_instituicao_pagamento_tip' => 'string|max:255'
        ]);

        $updated_instituicaoPagamento = $this->instituicaoPagamentoRepository->updateReg($id_empresa, $id_instituicao_pagamento, $request);

        return response()->json($updated_instituicaoPagamento,200);
    }

    /**
     * @OA\Delete(
     *     path="/instituicaoPagamento/{id_instituicao_pagamento}",
     *     summary="Deletar uma Instituicao de Pagamento",
     *     tags={"InstituicaoPagamento"},
     *     @OA\Parameter(
     *         name="id_instituicao_pagamento",
     *         in="path",
     *         description="ID da Instituicao de Pagamento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Instituicao de Pagamento deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao deletar a Instituicao de Pagamento"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_instituicao_pagamento) {
        $id_empresa = $this->getIdEmpresa($request);
        $inactive_instituicaoPagamento = $this->instituicaoPagamentoRepository->deleteReg($id_empresa, $id_instituicao_pagamento);

        return response()->json($inactive_instituicaoPagamento, 200);
    }
}
