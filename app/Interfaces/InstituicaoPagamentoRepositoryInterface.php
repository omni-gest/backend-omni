<?php

namespace App\Interfaces;

interface InstituicaoPagamentoRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_instituicao_pagamento);
    public function updateReg($id_empresa, $id_instituicao_pagamento, $request);
    public function deleteReg($id_empresa, $id_instituicao_pagamento);
}