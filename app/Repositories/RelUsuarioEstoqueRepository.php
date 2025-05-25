<?php

namespace App\Repositories;

use App\Interfaces\RelUsuarioEstoqueRepositoryInterface;
use App\Models\RelUsuarioEstoque;

class RelUsuarioEstoqueRepository implements RelUsuarioEstoqueRepositoryInterface
{
    public function getEstoqueByIdUsuario($id_user)
    {
        $result = RelUsuarioEstoque::getEstoqueByIdUsuario($id_user);

        return $result;
    }
}