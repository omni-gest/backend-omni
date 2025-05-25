<?php

namespace App\Repositories;

use App\Interfaces\PessoaRepositoryInterface;
use App\Models\Pessoa;

class PessoaRepository implements PessoaRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        $result = Pessoa::create($request,$id_empresa);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = Pessoa::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_pessoa, $id_empresa)
    {
        $result = Pessoa::getById($id_pessoa, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_pessoa, $request)
    {
        $result = Pessoa::updateReg($id_empresa, $id_pessoa, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_pessoa)
    {
        $result = Pessoa::deleteReg($id_empresa, $id_pessoa);

        return $result;
    }
}