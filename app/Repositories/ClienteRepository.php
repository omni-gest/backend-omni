<?php

namespace App\Repositories;

use App\Interfaces\ClienteRepositoryInterface;
use App\Models\Cliente;

class ClienteRepository implements ClienteRepositoryInterface
{
    public function create($request)
    {
        $result = Cliente::create($request);

        return $result;
    }

    public function getAll($id_empresa, $queryParams)
    {
        $result = Cliente::getAll($id_empresa, $queryParams);

        return $result;
    }

    public function getById($id_cliente, $id_empresa)
    {
        $result = Cliente::getById($id_cliente, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_cliente, $dados_atualizados)
    {
        $result = Cliente::updateReg($id_empresa, $id_cliente, $dados_atualizados);

        return $result;
    }

    public function deleteReg($id_empresa, $id_cliente)
    {
        $result = Cliente::deleteReg($id_empresa, $id_cliente);

        return $result;
    }
}
