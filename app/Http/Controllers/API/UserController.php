<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{

    public function __construct(
        private UserRepositoryInterface $userRepository
     )
     {
     }

     public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Get(
     *     path="/user/{id_user}",
     *     summary="Obtém os dados de um usuário",
     *     tags={"Usuario"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do usuário",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function get(Request $request, $id_usuario = null) {
        $id_empresa = $this->getIdEmpresa($request);

        if ($id_usuario) {
            $id_usuario = (int) $id_usuario;
            $data = $this->userRepository->getById($id_empresa, $id_usuario);
            return response()->json($data->original);
        }

        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);
        $per_page = ($per_page > 50) ? 50 : $per_page;

        $result = $this->userRepository->getAll($id_empresa, $filter, $per_page, $page_number);

        return $result;
    }

    /**
     * @OA\Put(
     *     path="/user/{id_user}",
     *     summary="Atualiza os dados de um usuário",
     *     tags={"Usuario"},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="url_img_user", type="string", format="uri")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuário atualizado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validação falhou",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update(Int $id_user, Request $request) {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6',
            'url_img_user' => 'string'
        ]);
        $updated_user = $this->userRepository->updateReg($id_empresa, $id_user, $request);

        return response()->json($updated_user, 200);
    }

    /**
     * @OA\Delete(
     *     path="/user/{id_user}",
     *     summary="Deleta um usuário",
     *     tags={"Usuario"},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deletado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuário deletado com sucesso")
     *         )
     *     )
     * )
     */
    public function delete(Request $request, Int $id_user) {
        $id_empresa = $this->getIdEmpresa($request);

        $inactive_user = $this->userRepository->deleteReg($id_empresa, $id_user);

        return response()->json($inactive_user, 200);
    }
}
