<?php

namespace App\Repositories;

use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\Estoque;
use Illuminate\Support\Facades\Log;

class EstoqueRepository implements EstoqueRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        print("Creating estoque with request: " . json_encode($request) . "\n");
        $request['id_empresa_est'] = $id_empresa;
        $result = Estoque::create($request);

        return $result;
    }

    public function getAll($id_empresa, $id_usuario, $queryParams)
    {
        $result = Estoque::getAll($id_empresa, $id_usuario, $queryParams);

        return $result;
    }

    public function getById($id_estoque, $id_empresa)
    {
        $result = Estoque::getById($id_estoque, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_estoque, $request)
    {
        $result = Estoque::updateReg($id_empresa, $id_estoque, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_estoque)
    {
        $result = Estoque::deleteReg($id_empresa, $id_estoque);

        return $result;
    }
}
