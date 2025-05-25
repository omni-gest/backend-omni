<?php

namespace App\Interfaces;

interface EstoqueItemRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_estoque_item);
    public function updateReg($id_empresa, $id_estoque_item, $request);
    public function deleteReg($id_empresa, $id_estoque_item);
    public function getByEstoqueMaterial($id_estoque_est, $id_material_eti);
}
