<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\OrigemClienteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrigemClienteController extends Controller{
    public function __construct(
        private OrigemClienteRepositoryInterface $OrigemClienteRepository
     )
     {
     }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'desc_origem_cliente_orc'   => 'required|string|max:255'
            ]);

        if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
        }


        $origem_cliente = $this->OrigemClienteRepository->create($request->all());


        return response()->json($origem_cliente,201);
    }

    public function get(Request $request, $id_origem_cliente_orc = null) {
        if($id_origem_cliente_orc){
            $data = $this->OrigemClienteRepository->getById($id_origem_cliente_orc);
            $data_array = json_decode($data);

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Origem de Cliente Não Existe',],400);
            }
            return $data;
        }
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->OrigemClienteRepository->getAll($filter, $per_page, $page_number);

        return $result;
    }

    public function update(int $id_origem_cliente_orc, Request $request){

        $dados_origem_cliente = $this->OrigemClienteRepository->getById($id_origem_cliente_orc);

        if(!$dados_origem_cliente){
            return response()->json(['erro' => 'Origem de Cliente não encontrado'], 404);
        }

        $validator = Validator::make($request->all(),[
            'desc_origem_cliente_orc'       => 'string|max:255',
            ]);
   
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dados_atualizados = [
            'desc_origem_cliente_orc'   => $request->desc_origem_cliente_orc  ?? $dados_origem_cliente->desc_origem_cliente_orc,
        ];

        $updated_origem_cliente = $this->OrigemClienteRepository->updateReg($id_origem_cliente_orc, $dados_atualizados);
        
        return response()->json($updated_origem_cliente,200);
    }

    public function delete(Int $id_origem_cliente_orc) {

        $inactive_origem_cliente = $this->OrigemClienteRepository->deleteReg($id_origem_cliente_orc);

        return response()->json($inactive_origem_cliente,200);
    }
}