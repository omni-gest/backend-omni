<?php

namespace App\Repositories;

use App\Interfaces\ComboRepositoryInterface;
use App\Models\Combo;

class ComboRepository implements ComboRepositoryInterface
{
    public function create($request)
    {
        $result = Combo::create($request);

        return $result;
    }

    public function updateReg($id_empresa, $id_combo, $request)
    {
        $result = Combo::updateReg($id_empresa, $id_combo, $request);

        return $result;
    }

    public function getAll($id_empresa,$id_centro_custo)
    {
        $result = Combo::getAll($id_empresa,$id_centro_custo);

        return $result;
    }

    public function getById($id_combo, $id_empresa)
    {
        $result = Combo::getById($id_combo, $id_empresa);

        return $result;
    }
}
