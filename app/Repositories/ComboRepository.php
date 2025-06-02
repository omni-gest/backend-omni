<?php

namespace App\Repositories;

use App\Interfaces\ComboRepositoryInterface;
use App\Models\Combo;

class ComboRepository implements ComboRepositoryInterface
{
    public function create($request, $id_empresa_cmb)
    {
        $request['id_empresa_cmb'] = $id_empresa_cmb;
        $result = Combo::create($request);

        return $result;
    }

    public function updateReg($id_empresa, $id_combo, $request)
    {
        $result = Combo::updateReg($id_empresa, $id_combo, $request);

        return $result;
    }

    public function getAll($id_empresa, $queryParams)
    {
        $result = Combo::getAllFormatado($id_empresa, $queryParams);

        return response()->json([
            'items' => $result,
            'total' => $result->count(),
        ]);
    }


    public function getById($id_empresa, $id_combo)
    {
        $result = Combo::getById($id_combo, $id_empresa);

        return $result;
    }
}
