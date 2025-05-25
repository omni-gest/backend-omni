<?php

namespace App\Repositories;

use App\Interfaces\MaterialRepositoryInterface;
use App\Models\Material;

class MaterialRepository implements MaterialRepositoryInterface
{
    public function create($request)
    {
        $result = Material::create($request);

        return $result;
    }

    public function getAll($id_empresa, $queryParams)
    {
        $result = Material::getAll($id_empresa, $queryParams);

        return $result;
    }

    public function getById($id_material, $id_empresa)
    {
        $result = Material::getById($id_material, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_material, $request)
    {
        $result = Material::updateReg($id_empresa, $id_material, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_material)
    {
        $result = Material::deleteReg($id_empresa, $id_material);

        return $result;
    }
}
