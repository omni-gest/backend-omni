<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CargoRepositoryInterface;
use Illuminate\Http\Request;

class CargoController extends Controller
{

    public function __construct(
        private CargoRepositoryInterface $cargoRepository
     )
     {
     }

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/cargo",
     *     summary="Cria um novo cargo",
     *     tags={"Cargo"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"desc_cargo_tcg"},
     *             @OA\Property(property="desc_cargo_tcg", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cargo criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cargo")
     *     )
     * )
     */
    public function create(Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_cargo_tcg' => 'required|string|max:255'
        ]);

        $cargo = $this->cargoRepository->create($request->all(),$id_empresa);

        return response()->json($cargo,201);
    }

    /**
     * @OA\Get(
     *     path="/cargo",
     *     summary="Lista todos os cargos",
     *     tags={"Cargo"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Quantidade de itens por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Filtro para buscar cargos",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page_number",
     *         in="query",
     *         description="Número da página",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de cargos retornada com sucesso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Cargo"))
     *     )
     * )
     */
    public function get(Request $request, $id_cargo = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if($id_cargo){
            $data = $this->cargoRepository->getById($id_cargo, $id_empresa);
            $data_array = json_decode($data->content());

            if(empty($data_array)){
                return response()->json([
                    'error' => 'Cargo Não Existe',],400);
            }
            return $data;
        }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->cargoRepository->getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    /**
     * @OA\Put(
     *     path="/cargo/{id_cargo}",
     *     summary="Atualiza um cargo existente",
     *     tags={"Cargo"},
     *     @OA\Parameter(
     *         name="id_cargo",
     *         in="path",
     *         description="ID do cargo a ser atualizado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"desc_cargo_tcg"},
     *             @OA\Property(property="desc_cargo_tcg", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cargo atualizado com sucesso"
     *     )
     * )
     */
    public function update(Request $request, Int $id_cargo) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'desc_cargo_tcg' => 'required|string|max:255'
        ]);

        $updated_cargo = $this->cargoRepository->updateReg($id_empresa, $id_cargo, $request);

        return response()->json($updated_cargo,200);
    }

    /**
     * @OA\Delete(
     *     path="/cargo/{id_cargo}",
     *     summary="Remove um cargo",
     *     tags={"Cargo"},
     *     @OA\Parameter(
     *         name="id_cargo",
     *         in="path",
     *         description="ID do cargo a ser removido",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cargo removido com sucesso"
     *     )
     * )
     */
    public function delete(Request $request, Int $id_cargo) {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_cargo = $this->cargoRepository->deleteReg($id_empresa, $id_cargo);

        return response()->json($inactive_cargo,200);
    }

}
