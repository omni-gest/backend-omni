<?php

namespace App\Repositories;

use App\Interfaces\ServicoTipoRepositoryInterface;
use App\Models\ServicoTipo;

class ServicoTipoRepository implements ServicoTipoRepositoryInterface
{
    public function create($request)
    {
        $result = ServicoTipo::create($request);

        return $result;
    }

    public function getAll($id_empresa, $queryParams)
    {
        $result = ServicoTipo::getAll($id_empresa, $queryParams);

        return $result;
    }

    public function getById($id_servico_tipo, $id_empresa)
    {
        $result = ServicoTipo::getById($id_servico_tipo, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_servico_tipo, $request)
    {
        $result = ServicoTipo::updateReg($id_empresa, $id_servico_tipo, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_servico_tipo)
    {
        $result = ServicoTipo::deleteReg($id_empresa, $id_servico_tipo);

        return $result;
    }
}
