<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;
use App\Models\User;

class EmpresaController extends Controller
{
    public function getIdEmpresa(Request $request) {
        $id_empresa = (int)$request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/empresa",
     *     summary="Cria uma nova empresa",
     *     tags={"Empresa"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"des_empresa_emp", "razao_social_empresa_emp", "cnpj_empresa_emp", "des_endereco_emp", "des_cidade_emp", "des_cep_emp", "des_tel_emp"},
     *             @OA\Property(property="des_empresa_emp", type="string"),
     *             @OA\Property(property="razao_social_empresa_emp", type="string"),
     *             @OA\Property(property="cnpj_empresa_emp", type="string"),
     *             @OA\Property(property="des_endereco_emp", type="string"),
     *             @OA\Property(property="des_cidade_emp", type="string"),
     *             @OA\Property(property="des_cep_emp", type="string"),
     *             @OA\Property(property="des_tel_emp", type="string"),
     *             @OA\Property(property="lnk_whatsapp_emp", type="string", nullable=true),
     *             @OA\Property(property="lnk_instagram_emp", type="string", nullable=true),
     *             @OA\Property(property="lnk_facebook_emp", type="string", nullable=true),
     *             @OA\Property(property="img_empresa_emp", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Empresa criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request)
    {
        $cnpj = $request->cnpj_empresa_emp;

        $messages = [
            'des_empresa_emp.required' => 'Nome da Empresa é obrigatório.',
            'razao_social_empresa_emp.required' => 'Razão Social é obrigatório.',
            'cnpj_empresa_emp.required' => 'CNPJ é obrigatório.',
            'des_endereco_emp.required' => 'Endereço é obrigatório.',
            'des_cidade_emp.required' => 'Cidade é obrigatório.',
            'des_cep_emp.required' => 'CEP é obrigatório.',
            'des_tel_emp.required' => 'Telefone é obrigatório.',
        ];

        $rules = [
            'des_empresa_emp' => 'required|string|max:255',
            'razao_social_empresa_emp' => 'required|string|max:255',
            'cnpj_empresa_emp' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!Empresa::validateCNPJ($value)) {
                    $fail('O CNPJ informado é inválido.');
                }
                if (Empresa::where('cnpj_empresa_emp', $value)->exists()) {
                    $fail('O CNPJ informado já está cadastrado.');
                }
            }],
            'des_endereco_emp' => 'required|string|max:255',
            'des_cidade_emp' => 'required|string|max:255',
            'des_cep_emp' => 'required|string|max:9',
            'des_tel_emp' => 'required|string|max:20',
            'lnk_whatsapp_emp' => 'nullable|url',
            'lnk_instagram_emp' => 'nullable|url',
            'lnk_facebook_emp' => 'nullable|url',
            'img_empresa_emp' => 'nullable|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $empresa = Empresa::create([
            'des_empresa_emp' => $request->des_empresa_emp,
            'razao_social_empresa_emp' => $request->razao_social_empresa_emp,
            'cnpj_empresa_emp' => $cnpj,
            'des_endereco_emp' => $request->des_endereco_emp,
            'des_cidade_emp' => $request->des_cidade_emp,
            'des_cep_emp' => $request->des_cep_emp,
            'des_tel_emp' => $request->des_tel_emp,
            'lnk_whatsapp_emp' => $request->lnk_whatsapp_emp,
            'lnk_instagram_emp' => $request->lnk_instagram_emp,
            'lnk_facebook_emp' => $request->lnk_facebook_emp,
            'img_empresa_emp' => $request->img_empresa_emp,
        ]);

        return response()->json(['message' => 'Empresa criada com sucesso.', 'empresa' => $empresa], 201);
    }

    /**
     * @OA\Get(
     *     path="/empresas",
     *     summary="Lista todas as empresas",
     *     tags={"Empresa"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Quantidade de registros por página",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Filtro para busca",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page_number",
     *         in="query",
     *         description="Número da página",
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de empresas retornada com sucesso"
     *     )
     * )
     */
    public function getAll(Request $request)
    {
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);

        return Empresa::getAll($filter,$per_page, $page_number);
    }

    /**
     * @OA\Put(
     *     path="/empresa/{id_empresa_emp}",
     *     summary="Atualiza uma empresa existente",
     *     tags={"Empresa"},
     *     @OA\Parameter(
     *         name="id_empresa_emp",
     *         in="path",
     *         required=true,
     *         description="ID da empresa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"des_empresa_emp", "razao_social_empresa_emp", "cnpj_empresa_emp", "des_endereco_emp", "des_cidade_emp", "des_cep_emp", "des_tel_emp"},
     *             @OA\Property(property="des_empresa_emp", type="string"),
     *             @OA\Property(property="razao_social_empresa_emp", type="string"),
     *             @OA\Property(property="cnpj_empresa_emp", type="string"),
     *             @OA\Property(property="des_endereco_emp", type="string"),
     *             @OA\Property(property="des_cidade_emp", type="string"),
     *             @OA\Property(property="des_cep_emp", type="string"),
     *             @OA\Property(property="des_tel_emp", type="string"),
     *             @OA\Property(property="lnk_whatsapp_emp", type="string", nullable=true),
     *             @OA\Property(property="lnk_instagram_emp", type="string", nullable=true),
     *             @OA\Property(property="lnk_facebook_emp", type="string", nullable=true),
     *             @OA\Property(property="img_empresa_emp", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Empresa não encontrada"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(Request $request, $id_empresa_emp)
    {
        $empresa = Empresa::where('id_empresa_emp', $id_empresa_emp)->first();

        if (!$empresa) {
            return response()->json(['error' => 'Empresa não encontrada.'], 404);
        }

        $messages = [
            'des_empresa_emp.required' => 'Nome da Empresa é obrigatório.',
            'razao_social_empresa_emp.required' => 'Razão Social é obrigatório.',
            'cnpj_empresa_emp.required' => 'CNPJ é obrigatório.',
            'des_endereco_emp.required' => 'Endereço é obrigatório.',
            'des_cidade_emp.required' => 'Cidade é obrigatório.',
            'des_cep_emp.required' => 'CEP é obrigatório.',
            'des_tel_emp.required' => 'Telefone é obrigatório.',
        ];

        $rules = [
            'des_empresa_emp' => 'required|string|max:255',
            'razao_social_empresa_emp' => 'required|string|max:255',
            'cnpj_empresa_emp' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($empresa) {
                    if (!Empresa::validateCNPJ($value)) {
                        $fail('O CNPJ informado é inválido.');
                    }
                    if (Empresa::where('cnpj_empresa_emp', $value)->where('id_empresa_emp', '!=', $empresa->id_empresa_emp)->exists()) {
                        $fail('O CNPJ informado já está cadastrado.');
                    }
                }
            ],
            'des_endereco_emp' => 'required|string|max:255',
            'des_cidade_emp' => 'required|string|max:255',
            'des_cep_emp' => 'required|string|max:9',
            'des_tel_emp' => 'required|string|max:20',
            'lnk_whatsapp_emp' => 'nullable|url',
            'lnk_instagram_emp' => 'nullable|url',
            'lnk_facebook_emp' => 'nullable|url',
            'img_empresa_emp' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Empresa::updateReg($id_empresa_emp, [
            'des_empresa_emp' => $request->des_empresa_emp,
            'razao_social_empresa_emp' => $request->razao_social_empresa_emp,
            'cnpj_empresa_emp' => $request->cnpj_empresa_emp,
            'des_endereco_emp' => $request->des_endereco_emp,
            'des_cidade_emp' => $request->des_cidade_emp,
            'des_cep_emp' => $request->des_cep_emp,
            'des_tel_emp' => $request->des_tel_emp,
            'lnk_whatsapp_emp' => $request->lnk_whatsapp_emp,
            'lnk_instagram_emp' => $request->lnk_instagram_emp,
            'lnk_facebook_emp' => $request->lnk_facebook_emp,
            'img_empresa_emp' => $request->img_empresa_emp,
        ]);

        return response()->json(['message' => 'Empresa atualizada com sucesso.', 'empresa' => $empresa], 200);
    }

    /**
     * @OA\Get(
     *     path="/{id_empresa_emp}/empresas",
     *     summary="Lista todos os usuários da empresa",
     *     tags={"Empresa"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Quantidade de registros por página",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Filtro para busca",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page_number",
     *         in="query",
     *         description="Número da página",
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários retornada com sucesso"
     *     )
     * )
     */
    public function getUsers(Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);
        $per_page = $request->query('per_page', 10);
        $filter = $request->query('filter', '');
        $page_number = $request->query('page_number', 1);

        return User::getAllByCompany($id_empresa, $filter,$per_page, $page_number);
    }

}
