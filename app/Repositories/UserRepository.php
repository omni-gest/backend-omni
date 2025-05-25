<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        $result = User::create($request,$id_empresa);

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = User::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_user, $id_empresa)
    {
        $result = User::getById($id_user, $id_empresa);

        return $result;
    }

    public function updateReg($id_empresa, $id_user, $request)
    {
        $result = User::updateReg($id_empresa, $id_user, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_user)
    {
        $result = User::deleteReg($id_empresa, $id_user);

        return $result;
    }
}