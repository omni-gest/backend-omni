<?php

namespace App\Repositories;

use App\Interfaces\CentroCustoRepositoryInterface;
use App\Models\CentroCusto;

class CentroCustoRepository implements CentroCustoRepositoryInterface
{
    public function create($request)
    {
        $result = CentroCusto::create($request);

        return $result;
    }

    public function getAll($id_usuario, $filter, $per_page, $page_number, $id_empresa, $getByCompany = false)
    {
        $result = CentroCusto::getAll($id_usuario, $filter, $per_page, $page_number, $id_empresa, $getByCompany);

        return $result;
    }

    public function getById($id_usuario, $id_CentroCusto)
    {
        $result = CentroCusto::getById($id_usuario, $id_CentroCusto);

        return $result;
    }

    public function updateReg($id_empresa, $id_CentroCusto, $request)
    {
        $result = CentroCusto::updateReg($id_empresa, $id_CentroCusto, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_CentroCusto)
    {
        $result = CentroCusto::deleteReg($id_empresa, $id_CentroCusto);

        return $result;
    }
}
