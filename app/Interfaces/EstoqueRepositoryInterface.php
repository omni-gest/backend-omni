<?php

namespace App\Interfaces;

interface EstoqueRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $id_usuario, $queryParams);
    public function getById($id_empresa, $id_estoque);
    public function updateReg($id_empresa, $id_estoque, $request);
    public function deleteReg($id_empresa, $id_estoque);
}
