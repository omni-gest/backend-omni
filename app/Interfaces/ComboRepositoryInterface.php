<?php

namespace App\Interfaces;

interface ComboRepositoryInterface
{
    public function create($request, $id_empresa_cmb);
    public function getAll($id_empresa, $queryParams);
    public function getById($id_empresa, $id_combo);
    public function updateReg($id_empresa, $id_combo, $request);
}
