<?php

namespace App\Repositories;

use App\Interfaces\InstituicaoPagamentoRepositoryInterface;
use App\Models\InstituicaoPagamento;

class InstituicaoPagamentoRepository implements InstituicaoPagamentoRepositoryInterface
{
    public function create($request)
    {
        $result = InstituicaoPagamento::create($request);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = InstituicaoPagamento::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_instituicao_pagamento, $id_empresa)
    {
        $result = InstituicaoPagamento::getById($id_instituicao_pagamento, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_instituicao_pagamento, $request)
    {
        $result = InstituicaoPagamento::updateReg($id_empresa, $id_instituicao_pagamento, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_instituicao_pagamento)
    {
        $result = InstituicaoPagamento::deleteReg($id_empresa, $id_instituicao_pagamento);

        return $result;
    }
}