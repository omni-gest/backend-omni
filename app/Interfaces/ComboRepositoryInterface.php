<?php

namespace App\Interfaces;

interface ComboRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa,$id_centro_custo);
    public function getById($id_empresa, $id_combo);
    public function updateReg($id_empresa, $id_combo, $request);
}
