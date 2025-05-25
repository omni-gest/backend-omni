<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\RelUsuarioCentroCustoRepositoryInterface;
use App\Interfaces\RelUsuarioMenuRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class AuthController extends Controller
{
    public function __construct(
        private RelUsuarioCentroCustoRepositoryInterface $relUsuarioCentroCustoRepository,
        private RelUsuarioMenuRepositoryInterface $relUsuarioMenuRepository
        )
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Login do usuário",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário logado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *             @OA\Property(property="authorization", type="object", @OA\Property(property="token", type="string"), @OA\Property(property="type", type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Não autorizado")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Não autorizado',
            ], 401);
        }

        $user = Auth::user();
        $user_centro_custo = $this->relUsuarioCentroCustoRepository->getCentroCustoByIdUsuario($user->id);
        $user->centro_custo_permission = $user_centro_custo;
        
        $usuarioMenu = $this->relUsuarioMenuRepository->getMenuByIdUsuario($user->id);
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
            'menu' => $usuarioMenu
        ]);
    }

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Registrar um novo usuário",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name", "email", "password"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nome do usuário"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Email do usuário"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="Senha do usuário"
     *                 ),
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     format="binary",
     *                     description="Avatar do usuário (opcional)"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário registrado com sucesso",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na validação dos dados",
     *     )
     * )
     */
    public function register(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);
        $request_formatted = current((array)$request->request);

        $validator = Validator::make(($request_formatted),[
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6',
            // 'url_img_user' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'url_img_user' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $filePath = null;
        // if ($request->hasFile('url_img_user')) {
        //     $filePath = $request->file('url_img_user')->store('images', 'public');
        // }

        $user = User::create([
            'name' => $request_formatted['name'],
            'email' => $request_formatted['email'],
            'password' => Hash::make($request_formatted['password']),
            'url_img_user' => $filePath,
            'id_empresa_d' => $id_empresa
        ]);

        return response()->json([
            'message' => 'Usuário criado com sucesso',
            'user' => $user
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Logout do usuário",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deslogado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Desconectado com sucesso")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Desconectado com sucesso',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/auth/refresh",
     *     summary="Atualiza o token de autorização",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Token atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *             @OA\Property(property="authorization", type="object", @OA\Property(property="token", type="string"), @OA\Property(property="type", type="string"))
     *         )
     *     )
     * )
     */
    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
