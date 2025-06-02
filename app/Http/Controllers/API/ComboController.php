<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ComboRepositoryInterface;
use App\Interfaces\RelComboMaterialRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComboController extends Controller
{

    public function __construct(
        private ComboRepositoryInterface $comboRepository,
        private RelComboMaterialRepositoryInterface $relComboRepository
    ) {
    }

    public function getIdEmpresa(Request $request)
    {
        $id_empresa = (int) $request->header('id-empresa-d');

        return $id_empresa;
    }

    public function create(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $validator = Validator::make($request->all(), [
            'desc_combo_cmb' => 'required|string|max:255',
            'id_centro_custo_cmb' => 'required|integer',
            'vlr_combo_cmb' => 'required|integer',
            'materiais' => 'required|array|min:1',
            'materiais.*.id_material_cbm' => 'required|integer',
            'materiais.*.qtd_material_cbm' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $combo = $this->comboRepository->create($request->all(), $id_empresa);
        $id_combo_cbm = $combo->id_combo_cmb;

        foreach ($request->materiais as $material) {
            $dadosMaterial = [
                'id_combo_cbm' => $id_combo_cbm,
                'id_material_cbm' => $material['id_material_cbm'],
                'qtd_material_cbm' => $material['qtd_material_cbm'],
            ];
            $this->relComboRepository->create($dadosMaterial, $id_empresa);
        }

        return response()->json([
            'combo' => $combo,
            'mensagem' => 'Kit cadastrado com sucesso.'
        ], 201);
    }


    public function get(Request $request, $id_combo = null, $id_centro_custo = null)
    {
        $id_empresa = $this->getIdEmpresa($request);

        if ($id_combo) {
            $data = $this->comboRepository->getById($id_empresa, $id_combo);
            $data_array = json_decode($data->content());

            if (empty($data_array)) {
                return response()->json(['error' => 'Combo Não Existe'], 400);
            }

            return $data;
        }

        $queryParams = (object) [
            'filter' => $request->input('filter'),
            'perPage' => $request->input('perPage', 10),
            'pageNumber' => $request->input('page', 1),
            'id_centro_custo_cmb' => $request->input('er') ?? $id_centro_custo,
        ];

        return $this->comboRepository->getAll($id_empresa, $queryParams);
    }


    public function update(Request $request, int $id_combo)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $validator = Validator::make($request->all(), [
            'desc_combo_cmb' => 'required|string|max:255',
            'id_centro_custo_cmb' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updated_combo = $this->comboRepository->updateReg($id_empresa, $id_combo, $request);

        return response()->json($updated_combo, 200);
    }
}
