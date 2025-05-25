<?php

namespace App\Interfaces;

interface CentroCustoRepositoryInterface
{
    public function create($request);
    public function getAll($id_usuario, $filter, $per_page, $page_number, $id_empresa, $getByCompany = false);
    public function getById($id_usuario, $id_centro_custo);
    public function updateReg($id_empresa, $id_centro_custo, $request);
    public function deleteReg($id_empresa, $id_centro_custo);
}
