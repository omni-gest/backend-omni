<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RelEmpresaMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaMenuController extends Controller
{
           
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

     /**
     * @OA\Post(
     *     path="/empresaMenu",
     *     summary="Cria um novo relacionamento entre empresa e menu",
     *     tags={"EmpresaMenu"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EmpresaMenu")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Relacionamento criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/EmpresaMenu")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request) {
        foreach ($request->all() as $empresa) {
            $empresaId = $empresa['id_empresa_emn'];
            $menusEnviados = $empresa['id_menu_emn'];

            $existingRecords = RelEmpresaMenu::where('id_empresa_emn', $empresaId)
                ->pluck('id_menu_emn')
                ->toArray();

            $menusParaRemover = array_diff($existingRecords, $menusEnviados);
            RelEmpresaMenu::where('id_empresa_emn', $empresaId)
                ->whereIn('id_menu_emn', $menusParaRemover)
                ->delete();

            $menusParaAdicionar = array_diff($menusEnviados, $existingRecords);
            $rel_empresa_menu = [];
            foreach ($menusParaAdicionar as $menu_id) {
                $rel_empresa_menu[] = RelEmpresaMenu::create([
                    'id_menu_emn'    => $menu_id,
                    'id_empresa_emn' => $empresaId
                ]);
            }
        }

        return response()->json([], 201);
    }


    /**
     * @OA\Get(
     *     path="/empresaMenu",
     *     summary="Obtém os menus associados a empresa logada",
     *     tags={"EmpresaMenu"},
     *     @OA\Response(
     *         response=200,
     *         description="Menus encontrados para a empresa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EmpresaMenu")
     *         )
     *     )
     * )
     */
    public function getMenuEmpresa(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);
        $data = RelEmpresaMenu::getMenuByIdEmpresa($id_empresa);

        return response()->json($data, 200);
    }

    // /**
    //  *     @OA\Get(
    //  *     path="/empresaMenu",
    //  *     summary="Obtém os menus associados a uma empresa",
    //  *     tags={"EmpresaMenu"},
    //  *     @OA\Response(
    //  *         response=200,
    //  *         description="Menus encontrados para a empresa",
    //  *         @OA\JsonContent(
    //  *             type="array",
    //  *             @OA\Items(ref="#/components/schemas/EmpresaMenu")
    //  *         )
    //  *     )
    //  * )
    //  */
    public function getMenuByIdEmpresa(Request $request)
    {
        $id_empresa = $request->id_empresa;
        $data = RelEmpresaMenu::getMenuByIdEmpresa($id_empresa);

        return response()->json($data, 200);
    }
}
