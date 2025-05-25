<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\RelComboMaterialRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ComboController;


class ComboMaterialController extends Controller
{
    public function __construct(
        private RelComboMaterialRepositoryInterface $relComboRepository
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
            'id_combo_cbm'      => 'required|integer',
            'id_material_cbm'   => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $combo_material = $this->relComboRepository->create($request->all(),$id_empresa);

        return response()->json($combo_material, 201);
    }
}
