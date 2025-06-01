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

    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $validator = Validator::make($request->all(), [
            'id_combo_cbm' => 'required|integer',
            'materiais'    => 'required|array|min:1',
            'materiais.*.id_material_cbm' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id_combo_cbm = $request->id_combo_cbm;
        $materiais = $request->materiais;

        $result = [];

        foreach ($materiais as $material) {
            $dados = [
                'id_combo_cbm'    => $id_combo_cbm,
                'id_material_cbm' => $material['id_material_cbm'],
                'id_empresa'      => $id_empresa,
            ];

            $result[] = $this->relComboRepository->create($dados, $id_empresa);
        }

        return response()->json($result, 201);
    }


    public function get(Request $request, $id_combo_material = null)
    {
        $id_empresa = $this->getIdEmpresa($request);

        if ($id_combo_material) {
            $data = $this->relComboRepository->getById($id_empresa, $id_combo_material);
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

        $result = $this->relComboRepository->getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }
}
