<?php

namespace App\Repositories;

use App\Interfaces\RelComboMaterialRepositoryInterface;
use App\Models\RelComboMaterial;

class RelComboMaterialRepository implements RelComboMaterialRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        $request['id_empresa_cbm'] = $id_empresa;
        $result = RelComboMaterial::create($request);

        return $result;
    }

    public function updateReg($id_empresa, $id_combo_material, $request)
    {
        $result = RelComboMaterial::updateReg($id_empresa, $id_combo_material, $request);

        return $result;
    }

    public function getAll($id_empresa,$id_centro_custo)
    {
        $result = RelComboMaterial::getAll($id_empresa,$id_centro_custo);

        return $result;
    }

    public function getById($id_combo_material, $id_empresa)
    {
        $result = RelComboMaterial::getById($id_combo_material, $id_empresa);

        return $result;
    }
}
