<?php

namespace App\Repositories;

use App\Interfaces\OrigemClienteRepositoryInterface;
use App\Models\OrigemCliente;

class OrigemClienteRepository implements OrigemClienteRepositoryInterface
{
    public function create($request)
    {
        $result = OrigemCliente::create($request);

        return $result;
    }

    public function getAll($filter, $per_page, $page_number)
    {
        $result = OrigemCliente::getAll($filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_origem_cliente_orc)
    {
        $result = OrigemCliente::getById($id_origem_cliente_orc);

        return $result;
    }

    public function updateReg($id_origem_cliente_orc, $dados_atualizados)
    {
        $result = OrigemCliente::updateReg($id_origem_cliente_orc, $dados_atualizados);

        return $result;
    }

    public function deleteReg($id_origem_cliente_orc)
    {
        $result = OrigemCliente::deleteReg($id_origem_cliente_orc);

        return $result;
    }
}