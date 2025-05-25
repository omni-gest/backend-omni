<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="MaterialMovimentacao",
 *     type="object",
 *     @OA\Property(property="id_movimentacao_item_mit", type="integer"),
 *     @OA\Property(
 *         property="id_movimentacao_mit",
 *         type="integer",
 *         description="Chave estrangeira referenciando a movimentação"
 *     ),
 *     @OA\Property(
 *         property="id_empresa_mit",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(
 *         property="id_material_mit",
 *         type="integer",
 *         description="Chave estrangeira referenciando o material"
 *     ),
 *     @OA\Property(property="qtd_material_mit", type="integer", description="Quantidade do material movimentado"),
 *     @OA\Property(property="is_ativo_mit", type="boolean", description="Indica se o item está ativo"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de criação"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data de atualização"),
 *     @OA\Property(
 *         property="tipo_movimentacao_mit",
 *         type="string",
 *         description="Tipo de movimentação do item"
 *     )
 * )
 */
class MaterialMovimentacao
{
}
