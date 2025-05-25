<?php

namespace App\Repositories;

use App\Interfaces\RelUsuarioMenuRepositoryInterface;
use App\Models\RelUsuarioMenu;

class RelUsuarioMenuRepository implements RelUsuarioMenuRepositoryInterface
{
    public function getMenuByIdUsuario($id_user)
    {
        $result = RelUsuarioMenu::getMenuByIdUsuario($id_user);

        return $result;
    }
}