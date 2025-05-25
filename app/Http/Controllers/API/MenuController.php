<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    // /**
    //  * @OA\Get(
    //  *     path="/menu",
    //  *     summary="Obtém todos os menus disponíveis",
    //  *     tags={"Menu"},
    //  *     @OA\Response(
    //  *         response=200,
    //  *         description="Menus encontrados.",
    //  *         @OA\JsonContent(
    //  *             type="array",
    //  *             @OA\Items(ref="#/components/schemas/Menu")
    //  *         )
    //  *     )
    //  * )
    //  */
    public function getAll(Request $request)
    {
        $data = Menu::getAll();

        return response()->json($data, 200);
    }
}
