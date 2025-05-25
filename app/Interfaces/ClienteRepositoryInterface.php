<?php

namespace App\Interfaces;

interface ClienteRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa, $queryParams);
    public function getById($id_empresa, $id_cliente);
    public function updateReg($id_empresa, $id_cliente, $dados_atualizados);
    public function deleteReg($id_empresa, $id_cliente);
}
