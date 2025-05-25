<?php

namespace App\Interfaces;

interface ServicoTipoRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa, $queryParams);
    public function getById($id_empresa, $id_servico_tipo);
    public function updateReg($id_empresa, $id_servico_tipo, $request);
    public function deleteReg($id_empresa, $id_servico_tipo);
}
