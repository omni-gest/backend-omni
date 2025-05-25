<?php

namespace App\Repositories;

use App\Interfaces\ServicoRepositoryInterface;
use App\Models\Servico;

class ServicoRepository implements ServicoRepositoryInterface
{
    public function getTopThreeEmployeesByTotalTypeService($centro_custo, $data_inicio, $data_fim)
    {
        $result = Servico::getTopThreeEmployeesByTotalTypeService($centro_custo, $data_inicio, $data_fim);

        return $result;
    }
}