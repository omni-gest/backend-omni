<?php

namespace App\Repositories;

use App\Interfaces\CargoRepositoryInterface;
use App\Models\Cargo;

class CargoRepository implements CargoRepositoryInterface
{
    public function create($request, $id_empresa)
    {
        $result = Cargo::create(array_merge(
            $request,
            ['id_empresa_tcg' => $id_empresa]
        ));

        return $result;
    }

    public function getAll($id_empresa, $filter, $per_page, $page_number)
    {
        $result = Cargo::getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    public function getById($id_cargo, $id_empresa)
    {
        $result = Cargo::getById($id_empresa, $id_cargo);

        return $result;
    }

    public function updateReg($id_empresa, $id_cargo, $request)
    {
        $result = Cargo::updateReg($id_empresa, $id_cargo, $request);

        return $result;
    }

    public function deleteReg($id_empresa, $id_cargo)
    {
        $result = Cargo::deleteReg($id_empresa, $id_cargo);

        return $result;
    }
}
