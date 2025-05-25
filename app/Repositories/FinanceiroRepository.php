<?php

namespace App\Repositories;

use App\Interfaces\FinanceiroRepositoryInterface;
use App\Models\Financeiro;

class FinanceiroRepository implements FinanceiroRepositoryInterface
{
    public function create($request)
    {
        $result = Financeiro::create($request);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number, $type = null)
    {
        $result = Financeiro::getAll($id_empresa, $filter, $per_page, $page_number, $type);

        return $result;
    }

    public function getById($id_financeiro, $id_empresa)
    {
        $result = Financeiro::getById($id_financeiro, $id_empresa);

        return $result;
    }
}
