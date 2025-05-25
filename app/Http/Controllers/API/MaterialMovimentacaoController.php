<?php

namespace App\Http\Controllers\api;
use App\Models\MaterialMovimentacao;
use App\Models\Material;
use App\Interfaces\EstoqueItemRepositoryInterface;
use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\MaterialMovimentacaoItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EstoqueItem;
use Illuminate\Http\Request;

class MaterialMovimentacaoController extends Controller
{
    public function __construct(
        private EstoqueItemRepositoryInterface $estoqueItemRepository,
        private EstoqueRepositoryInterface $estoqueRepository
    ) {
    }

    public function getIdEmpresa(Request $request)
    {
        $id_empresa = (int) $request->header('id-empresa-d');

        return $id_empresa;
    }

    /**
     * @OA\Post(
     *     path="/materialMovimentacao/{tipo_movimentacao}",
     *     summary="Criar movimentação de material",
     *     description="Cria uma movimentação de material de entrada ou saída",
     *     tags={"MaterialMovimentacao"},
     *     @OA\Parameter(
     *         name="tipo_movimentacao",
     *         in="path",
     *         required=true,
     *         description="Tipo de movimentação (entrada ou saída)"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"des_estoque_item_eti", "id_estoque", "id_centro_custo_mov", "materiais"},
     *             @OA\Property(property="txt_movimentacao_mov", type="string", description="Descrição da movimentação"),
     *             @OA\Property(property="id_estoque", type="integer", description="ID do estoque"),
     *             @OA\Property(property="id_centro_custo_mov", type="integer", description="ID do centro de custo"),
     *             @OA\Property(property="materiais", type="array", @OA\Items(
     *                 @OA\Property(property="id_material_mte", type="integer", description="ID do material"),
     *                 @OA\Property(property="qtd_material_mit", type="integer", description="Quantidade do material"),
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movimentação criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/MaterialMovimentacao")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function create(Request $request, $tipo_movimentacao)
    {
        $id_empresa = $this->getIdEmpresa($request);

        // Validação dos campos
        $request->validate([
            'id_estoque_mov' => 'required|int',
            'materiais' => 'required|array',
            'materiais.*.id_material_mte' => 'required|int',
            'materiais.*.qtd_material_mit' => 'required|int|min:1',
        ]);

        // Inicia a transação
        DB::beginTransaction();

        $estoque = $this->estoqueRepository->getById($id_empresa, $request->id_estoque_mov);
        if (!$estoque->getData()) {
            return response()->json([
                'message' => 'Estoque não encontrado.',
            ], 422);
        }

        $estoque = $estoque->getData()[0];

        try {
            // Cria a movimentação de material
            $materialMov = MaterialMovimentacao::create([
                'txt_movimentacao_mov' => $request->des_estoque_item_eti,
                'id_centro_custo_mov' => $estoque->id_centro_custo_est,
                'is_ativo_mov' => 1,
                'id_empresa_mov' => $id_empresa,
            ]);

            foreach ($request->materiais as $material) {
                $id_material = $material['id_material_mte'];
                $quantidade = $material['qtd_material_mit'];

                $estoque_item = $this->estoqueItemRepository->getByEstoqueMaterial(
                    $estoque->id_estoque_est,
                    $id_material
                );

                if ($tipo_movimentacao === 'entrada') {
                    if ($estoque_item) {
                        $estoque_item->qtd_estoque_item_eti += $quantidade;
                        $this->estoqueItemRepository->updateReg($id_empresa, $estoque_item->id_estoque_item_eti, $estoque_item);
                    } else {
                        $this->estoqueItemRepository->create([
                            'id_material_eti' => $id_material,
                            'id_empresa_eti' => $id_empresa,
                            'id_estoque_eti' => $estoque->id_estoque_est,
                            'qtd_estoque_item_eti' => $quantidade,
                        ], $id_empresa);
                    }

                    MaterialMovimentacaoItem::create([
                        'id_movimentacao_mit' => $materialMov->id,
                        'id_material_mit' => $id_material,
                        'qtd_material_mit' => $quantidade,
                        'tipo_movimentacao_mit' => 'entrada',
                    ]);
                } elseif ($tipo_movimentacao === 'saida') {
                    if (!$estoque_item || $estoque_item->qtd_estoque_item_eti < $quantidade) {

                        $material = Material::getById($id_empresa, $id_material);

                        $des_material_mte = $material->getData()[0]->des_material_mte;

                        return response()->json([
                            'message' => "Quantidade insuficiente no estoque para o produto {$des_material_mte}.",
                        ], 422);
                    }

                    $estoque_item->qtd_estoque_item_eti -= $quantidade;
                    $this->estoqueItemRepository->updateReg($id_empresa, $estoque_item->id_estoque_item_eti, $estoque_item);

                    MaterialMovimentacaoItem::create([
                        'id_movimentacao_mit' => $materialMov->id,
                        'id_material_mit' => $id_material,
                        'qtd_material_mit' => -$quantidade,
                        'tipo_movimentacao_mit' => 'saida',
                    ]);
                }
            }

            DB::commit();

            return response()->json($materialMov, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *     path="/materialMovimentacao/{id_material}",
     *     summary="Obter movimentação de material",
     *     description="Obtém a movimentação de materiais por ID ou lista de todas",
     *     tags={"MaterialMovimentacao"},
     *     @OA\Parameter(
     *         name="id_material",
     *         in="path",
     *         required=false,
     *         description="ID do material",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de movimentações",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MaterialMovimentacao")
     *         )
     *     )
     * )
     */
    public function get(Request $request, $id_material = null)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $tipo_movimentacao = $request->query('tipoMovimentacao', null);

        $data = MaterialMovimentacao::get($id_empresa, $tipo_movimentacao, $id_material);

        $input_array = $data->toArray();

        $data = $this->groupMovimentacaoMaterialByMovimentacaoMaterialItem($input_array);
        // return $data;
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/materialMovimentacao/{id_movimentacao}",
     *     summary="Atualizar movimentação de material",
     *     description="Atualiza a descrição da movimentação de material",
     *     tags={"MaterialMovimentacao"},
     *     @OA\Parameter(
     *         name="id_movimentacao",
     *         in="path",
     *         required=true,
     *         description="ID da movimentação",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"txt_movimentacao_mov"},
     *             @OA\Property(property="txt_movimentacao_mov", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movimentação atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(int $id_movimentacao, Request $request)
    {
        $id_empresa = $this->getIdEmpresa($request);

        $request->validate([
            'txt_movimentacao_mov' => 'required|string'
        ]);
        MaterialMovimentacao::updateReg($id_empresa, $id_movimentacao, $request);
    }

    /**
     * @OA\Delete(
     *     path="/materialMovimentacao/{id_movimentacao}",
     *     summary="Deletar movimentação de material",
     *     description="Desativa uma movimentação de material",
     *     tags={"MaterialMovimentacao"},
     *     @OA\Parameter(
     *         name="id_movimentacao",
     *         in="path",
     *         required=true,
     *         description="ID da movimentação",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movimentação desativada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movimentação não encontrada"
     *     )
     * )
     */
    public function delete(Request $request, int $id_movimentacao)
    {
        $id_empresa = $this->getIdEmpresa($request);

        MaterialMovimentacao::deleteReg($id_empresa, $id_movimentacao);
    }

    private function groupMovimentacaoMaterialByMovimentacaoMaterialItem($input_array)
    {
        // variavel de saida
        $output_array = [];

        // agrupa materiais
        foreach ($input_array as $item) {
            $id = $item['id_movimentacao_mov'];
            if (!isset($output_array[$id])) {
                $output_array[$id] = [
                    ...$item,
                    'materiais' => [],
                ];
                unset($output_array[$id]['id_material_mte']);
                unset($output_array[$id]['des_material_mte']);
                unset($output_array[$id]['vlr_material_mte']);
                unset($output_array[$id]['des_reduz_unidade_und']);
                unset($output_array[$id]['id_material_mit']);
                unset($output_array[$id]['qtd_material_mit']);
            }

            if ($item['id_material_mte'] !== null) {
                $temp = array_filter($output_array[$id]['materiais'], function ($reg) use ($item) {
                    return $reg['id_material_mte'] == $item['id_material_mte'];
                });
                if (count($temp) == 0) {
                    $output_array[$id]['materiais'][] = [
                        "id_material_mte" => $item['id_material_mte'],
                        "des_material_mte" => $item['des_material_mte'],
                        "qtd_material_mit" => $item['qtd_material_mit']
                    ];
                }
            }
        }

        // Converte o array associativo em um array indexado
        $output_array = array_values($output_array);
        return $output_array;
    }
}
