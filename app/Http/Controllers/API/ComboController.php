<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ComboRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComboController extends Controller
{
    
    public function __construct(
       private ComboRepositoryInterface $comboRepository
    )
    {
    }

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request){
        $id_empresa = $this->getIdEmpresa($request);

        $validator = Validator::make($request->all(), [
            'desc_combo_cmb'      => 'required|string|max:255',
            'id_empresa_cmb'      => 'required|integer',
            'id_centro_custo_cmb' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $combo = $this->comboRepository->create($request->all(),$id_empresa);

        return response()->json($combo, 201);
    }

    public function update(Request $request, Int $id_combo){
        $id_empresa = $this->getIdEmpresa($request);

        $validator = Validator::make($request->all(), [
            'desc_combo_cmb'        => 'required|string|max:255',
            'id_empresa_cmb'        => 'required|integer',
            'id_centro_custo_cmb'   => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updated_combo = $this->comboRepository->updateReg($id_empresa, $id_combo, $request);

        return response()->json($updated_combo, 200);
    }
}