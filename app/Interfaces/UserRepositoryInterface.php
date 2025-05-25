<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function create($request, $id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_empresa, $id_user);
    public function updateReg($id_empresa, $id_user, $request);
    public function deleteReg($id_empresa, $id_user);
}