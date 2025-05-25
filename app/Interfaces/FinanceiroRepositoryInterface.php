<?php

namespace App\Interfaces;

interface FinanceiroRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa, $filter, $per_page, $page_number, $type = null);
    public function getById($id_empresa, $id_cliente);
}
