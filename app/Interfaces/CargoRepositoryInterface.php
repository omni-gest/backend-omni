<?php

namespace App\Interfaces;

interface CargoRepositoryInterface
{
    public function create($request,$id_empresa);
    public function getAll($id_empresa, $filter, $per_page, $page_number);
    public function getById($id_cargo, $id_empresa);
    public function updateReg($id_empresa, $id_cargo, $request);
    public function deleteReg($id_empresa, $id_cargo);
}