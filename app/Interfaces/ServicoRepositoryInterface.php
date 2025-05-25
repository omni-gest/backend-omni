<?php

namespace App\Interfaces;

interface ServicoRepositoryInterface
{
    public function getTopThreeEmployeesByTotalTypeService($centrosCusto, $dataInicio, $dataFim);
}