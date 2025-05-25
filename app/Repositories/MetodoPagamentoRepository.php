<?php

namespace App\Repositories;

use App\Interfaces\MetodoPagamentoRepositoryInterface;
use App\Models\MetodoPagamento;

class MetodoPagamentoRepository implements MetodoPagamentoRepositoryInterface
{
    public function create($request)
    {
        $result = MetodoPagamento::create($request);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = MetodoPagamento::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_metodo_pagamento, $id_empresa)
    {
        $result = MetodoPagamento::getById($id_metodo_pagamento, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_metodo_pagamento, $request)
    {
        $result = MetodoPagamento::updateReg($id_empresa, $id_metodo_pagamento, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_metodo_pagamento)
    {
        $result = MetodoPagamento::deleteReg($id_empresa, $id_metodo_pagamento);

        return $result;
    }
}