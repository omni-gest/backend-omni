<?php

namespace App\Repositories;

use App\Interfaces\VendaRepositoryInterface;
use App\Models\RelVendaMaterial;

class VendaRepository implements VendaRepositoryInterface
{
    public function getTotalMateriaisPorVenda($centros_custo,string $data_inicio,string $data_fim)
    {
        $result = RelVendaMaterial::getTotalMateriaisPorVenda($centros_custo,$data_inicio,$data_fim);

        return $result;
    }

    public function getValorMateriaisPorVenda($centros_custo,string $data_inicio,string $data_fim)
    {
        $result = RelVendaMaterial::getValorMateriaisPorVenda($centros_custo,$data_inicio,$data_fim);

        return $result;
    }

    public function getTopTresFuncionariosPorVenda($centros_custo,string $data_inicio,string $data_fim)
    {
        $result = RelVendaMaterial::getTopTresFuncionariosPorVenda($centros_custo,$data_inicio,$data_fim);

        return $result;
    }

    public function getVendasPorCentroCusto($centros_custo,string $data_inicio,string $data_fim)
    {
        $result = RelVendaMaterial::getVendasPorCentroCusto($centros_custo,$data_inicio,$data_fim);

        return $result;
    }

    public function getVendasPorCliente($centros_custo,string $data_inicio,string $data_fim)
    {
        $result = RelVendaMaterial::getVendasPorCliente($centros_custo,$data_inicio,$data_fim);

        return $result;
    }

    public function getTotalVendasPorOrigemCliente($centros_custo,string $data_inicio,string $data_fim)
    {
        $result = RelVendaMaterial::getTotalVendasPorOrigemCliente($centros_custo,$data_inicio,$data_fim);

        return $result;
    }

    public function getTotalVendas($centros_custo,string $data_inicio,string $data_fim)
    {
        $result = RelVendaMaterial::getTotalVendas($centros_custo,$data_inicio,$data_fim);

        return $result;
    }
}
