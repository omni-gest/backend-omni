<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RelUsuarioEstoque;
use Illuminate\Http\Request;



class RelUsuarioEstoqueController extends Controller
{
    public function create(Request $request){
        $estoques_atuais = RelUsuarioEstoque::where('id_user_rue', $request->id_user_rue)
            ->pluck('id_estoque_rue')
            ->toArray();

        $estoques_novos = (array) $request->id_estoque_rue;

        $estoques_para_remover = array_diff($estoques_atuais, $estoques_novos);
        if (!empty($estoques_para_remover)) {
            RelUsuarioEstoque::where('id_user_rue', $request->id_user_rue)
                ->whereIn('id_estoque_rue', $estoques_para_remover)
                ->delete();
        }

        $estoques_para_adicionar = array_diff($estoques_novos, $estoques_atuais);
        foreach ($estoques_para_adicionar as $estoque_id) {
            RelUsuarioEstoque::create([
                'id_estoque_rue' => $estoque_id,
                'id_user_rue' => $request->id_user_rue
            ]);
        }

        return response()->json([], 201);
    }


     public function getEstoqueByIdUsuario($id_usuario){

        $data = RelUsuarioEstoque::getEstoqueByIdUsuario($id_usuario);

        return response()->json($data, 200);
    }

}
