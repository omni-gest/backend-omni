<?php

namespace App\Interfaces;

interface FornecedorRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_fornecedor);
    public function updateReg($id_empresa, $id_fornecedor, $request);
    public function deleteReg($id_empresa, $id_fornecedor);
}
