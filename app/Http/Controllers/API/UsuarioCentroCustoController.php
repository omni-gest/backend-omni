<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RelUsuarioCentroCusto;

class UsuarioCentroCustoController extends Controller
{
     /**
     * @OA\Post(
     *     path="/api/usuarioCentroCusto",
     *     summary="Associa centros de custo a um usuário",
     *     operationId="createUsuarioCentroCusto",
     *     tags={"UsuarioCentroCusto"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_centro_custo_ccu", "id_user"},
     *             @OA\Property(
     *                 property="id_centro_custo_ccu",
     *                 type="array",
     *                 @OA\Items(type="integer"),
     *                 description="Lista de IDs dos centros de custo a serem associados ao usuário"
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
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UsuarioCentroCusto"))
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
        $existingRecords = RelUsuarioCentroCusto::where('id_user', $request->id_user)
        ->pluck('id_centro_custo_ccu')
        ->toArray();
        $centroCustoParaRemover = array_diff($existingRecords, $request->id_centro_custo_ccu);
        RelUsuarioCentroCusto::where('id_user', $request->id_user)
            ->whereIn('id_centro_custo_ccu', $centroCustoParaRemover)
            ->delete();

        $centroCustoParaAdicionar = array_diff($request->id_centro_custo_ccu, $existingRecords);
        $rel_usuario_centro_custo = [];
        foreach ($centroCustoParaAdicionar as $centro_custo_id) {
            $rel_usuario_centro_custo[] = RelUsuarioCentroCusto::create([
                'id_centro_custo_ccu'    => $centro_custo_id,
                'id_user' => $request->id_user
            ]);
        }

        return response()->json([], 201);
    }

    /**
     * @OA\Get(
     *     path="/usuarioCentroCusto/{id_user}",
     *     summary="Obtém os centros de custo associados a um usuário",
     *     tags={"UsuarioCentroCusto"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do centro de custo associado ao usuário",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function getCentroCustoByIdUsuario(Int $id_usuario)
    {
        $data = RelUsuarioCentroCusto::getCentroCustoByIdUsuario($id_usuario);

        return response()->json($data, 200);
    }
}
