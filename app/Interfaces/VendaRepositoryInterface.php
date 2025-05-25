<?php

namespace App\Interfaces;

interface VendaRepositoryInterface
{
    public function getTotalMateriaisPorVenda($centros_custo,string $data_inicio,string $data_fim);
    public function getValorMateriaisPorVenda($centros_custo,string $data_inicio,string $data_fim);
    public function getTopTresFuncionariosPorVenda($centros_custo,string $data_inicio,string $data_fim);
    public function getVendasPorCentroCusto($centros_custo,string $data_inicio,string $data_fim);
    public function getVendasPorCliente($centros_custo,string $data_inicio,string $data_fim);
    public function getTotalVendasPorOrigemCliente($centros_custo,string $data_inicio,string $data_fim);
}