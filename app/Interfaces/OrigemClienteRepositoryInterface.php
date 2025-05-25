<?php

namespace App\Interfaces;

interface OrigemClienteRepositoryInterface
{
    public function create($request);
    public function getAll($filter, $per_page, $page_number);
    public function getById($id_origem_cliente_orc);
    public function updateReg($id_origem_cliente_orc, $dados_atualizados);
    public function deleteReg($id_origem_cliente_orc);
}
