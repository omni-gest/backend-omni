<?php

namespace App\Interfaces;

interface RelComboMaterialRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa,$id_centro_custo);
    public function getById($id_empresa, $id_combo_material);
    public function updateReg($id_empresa, $id_combo_material, $request);
}
