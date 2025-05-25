<?php

namespace App\Interfaces;

interface MaterialRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa, $queryParams);
    public function getById($id_empresa, $id_material);
    public function updateReg($id_empresa, $id_material, $request);
    public function deleteReg($id_empresa, $id_material);
}
