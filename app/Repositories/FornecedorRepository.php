<?php

namespace App\Repositories;

use App\Interfaces\FornecedorRepositoryInterface;
use App\Models\Fornecedor;

class FornecedorRepository implements FornecedorRepositoryInterface
{
    public function create($request)
    {
        $result = Fornecedor::create($request);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = Fornecedor::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_fornecedor, $id_empresa)
    {
        $result = Fornecedor::getById($id_fornecedor, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_fornecedor, $request)
    {
        $result = Fornecedor::updateReg($id_empresa, $id_fornecedor, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_fornecedor)
    {
        $result = Fornecedor::deleteReg($id_empresa, $id_fornecedor);

        return $result;
    }
}
