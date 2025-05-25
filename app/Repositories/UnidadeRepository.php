<?php

namespace App\Repositories;

use App\Interfaces\UnidadeRepositoryInterface;
use App\Models\Unidade;

class UnidadeRepository implements UnidadeRepositoryInterface
{
    public function create($request)
    {
        $result = Unidade::create($request);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = Unidade::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_unidade_und, $id_empresa)
    {
        $result = Unidade::getById($id_unidade_und, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_unidade_und, $request)
    {
        $result = Unidade::updateReg($id_empresa, $id_unidade_und, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_unidade_und)
    {
        $result = Unidade::deleteReg($id_empresa, $id_unidade_und);

        return $result;
    }
}
