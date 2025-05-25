<?php

namespace App\Interfaces;

interface PessoaRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_pessoa);
    public function updateReg($id_empresa, $id_pessoa, $request);
    public function deleteReg($id_empresa, $id_pessoa);
}