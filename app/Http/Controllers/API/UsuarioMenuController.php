<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RelUsuarioMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UsuarioMenuController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/usuario-menu",
     *     summary="Associa menus a um usuário",
     *     operationId="createUsuarioMenu",
     *     tags={"UsuarioMenu"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_menu_usm", "id_user"},
     *             @OA\Property(
     *                 property="id_menu_usm",
     *                 type="array",
     *                 @OA\Items(type="integer"),
     *                 description="Lista de IDs dos menus a serem associados ao usuário"
     *             ),
     *             @OA\Property(
     *                 property="id_user",
     *                 type="integer",
     *                 description="ID do usuário"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Associação criada com sucesso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UsuarioMenu"))
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function create(Request $request) {
        $existingRecords = RelUsuarioMenu::where('id_user', $request->id_user)
        ->pluck('id_menu_usm')
        ->toArray();

        $menusParaRemover = array_diff($existingRecords, $request->id_menu_usm);
        RelUsuarioMenu::where('id_user', $request->id_user)
            ->whereIn('id_menu_usm', $menusParaRemover)
            ->delete();

        $menusParaAdicionar = array_diff($request->id_menu_usm, $existingRecords);
        $rel_empresa_menu = [];
        foreach ($menusParaAdicionar as $menu_id) {
            $rel_empresa_menu[] = RelUsuarioMenu::create([
                'id_menu_usm'    => $menu_id,
                'id_user' => $request->id_user
            ]);
        }

        return response()->json([], 201);
    }

    // /**
    //  *     @OA\Get(
    //  *     path="/usuarioMenu",
    //  *     summary="Obtém os menus associados ao usuário",
    //  *     tags={"UsuarioMenu"},
    //  *     @OA\Response(
    //  *         response=200,
    //  *         description="Menus encontrados para o usuário",
    //  *         @OA\JsonContent(
    //  *             type="array",
    //  *             @OA\Items(ref="#/components/schemas/UsuarioMenu")
    //  *         )
    //  *     )
    //  * )
    //  */
    public function getMenuByIdUsuario(Request $request, Int $id_usuario)
    {
        $data = RelUsuarioMenu::getMenuByIdUsuario($id_usuario);

        return response()->json($data, 200);
    }
}
