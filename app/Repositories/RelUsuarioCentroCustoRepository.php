<?php

namespace App\Repositories;

use App\Interfaces\RelUsuarioCentroCustoRepositoryInterface;
use App\Models\RelUsuarioCentroCusto;

class RelUsuarioCentroCustoRepository implements RelUsuarioCentroCustoRepositoryInterface
{
    public function getCentroCustoByIdUsuario($id_user)
    {
        $result = RelUsuarioCentroCusto::getCentroCustoByIdUsuario($id_user);

        return $result;
    }
}