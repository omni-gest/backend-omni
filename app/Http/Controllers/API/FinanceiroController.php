<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\FinanceiroRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\FinanceiroReferenciaEnum;



class FinanceiroController extends Controller
{
    public function __construct(
        private FinanceiroRepositoryInterface $financeiroRepository
     )
     {
     }

    public function getIdEmpresa(Request $request)
    {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $validator = Validator::make($request->all(), [
            'vlr_financeiro_fin'      => 'required|integer|min:0',
            'tipo_transacao_fin'      => 'required|in:0,1', // 0 = entrada, 1 = saída
            'id_centro_custo_fin'     => 'required|exists:tb_centro_custo,id_centro_custo_cco',
            'id_metodo_pagamento_fin' => 'required|exists:tb_metodo_pagamento,id_metodo_pagamento_tmp',
            'id_referencia_fin'       => 'nullable|integer',
            'tipo_referencia_fin'     => 'required|in:0,1,2,3', // 0 = manual, 1 = venda, 2 = serviço, 3 = compra, etc.
        ]);

        if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
        }

        $request = $request->merge(['id_empresa_fin' => $id_empresa]);
        $movimentacao_financeira = $this->financeiroRepository->create($request->all());

        return response()->json($movimentacao_financeira,201);
    }


    public function get(Request $request, $tipo_transacao = null) {
        $id_empresa = $this->getIdEmpresa($request);

        // if ($id_financeiro) {
        //     $data = $this->financeiroRepository->getById($id_empresa, $id_financeiro);
        //     $data_array = json_decode($data->content(), true);

        //     if (empty($data_array)) {
        //         return response()->json([
        //             'error' => 'Transferência Não Encontrada',
        //         ], 400);
        //     }

        //     $data_array['tipo_transacao_text'] = $data_array['tipo_transacao_fin'] == 0 ? 'Entrada' : 'Saída';
        //     $data_array['tipo_referencia_text'] = FinanceiroReferenciaEnum::tryFrom($data_array['tipo_referencia_fin'])?->name ?? 'Desconhecido';

        //     return response()->json($data_array);
        // }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $type = $request->query('type', null);
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->financeiroRepository->getAll($id_empresa, $filter, $per_page, $page_number, $type);
        $result_array = json_decode($result->content(), true);

        if (isset($result_array['items'])) {
            $result_array['items'] = array_map(function ($item) {
                $item['tipo_transacao_text'] = $item['tipo_transacao_fin'] == 0 ? 'Entrada' : 'Saída';
                $item['tipo_referencia_text'] = FinanceiroReferenciaEnum::tryFrom($item['tipo_referencia_fin'])?->name ?? 'Desconhecido';
                return $item;
            }, $result_array['items']);
        }

        return response()->json($result_array);
    }

}
