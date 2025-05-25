<?php

namespace App\Interfaces;

interface UnidadeRepositoryInterface
{
    public function create($request);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_unidade_und);
    public function updateReg($id_empresa, $id_unidade_und, $request);
    public function deleteReg($id_empresa, $id_unidade_und);
}