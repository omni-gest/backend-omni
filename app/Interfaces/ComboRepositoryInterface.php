<?php

namespace App\Interfaces;

interface ComboRepositoryInterface
{
    public function create($request);
    public function updateReg($id_empresa, $id_combo, $request);
}
