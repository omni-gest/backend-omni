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
}
