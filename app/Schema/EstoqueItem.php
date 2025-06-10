<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="estoqueItem",
 *     type="object",
 *     @OA\Property(property="id_estoque_item_eti", type="integer"),
 *     @OA\Property(
 *         property="id_material_eti",
 *         type="integer",
 *         description="Chave estrangeira referenciando o Material"
 *     ),
 *     @OA\Property(
 *         property="id_empresa_eti",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(
 *         property="id_centro_custo_eti",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de Custo"
 *     ),
 *     @OA\Property(property="des_estoque_item_eti", type="string"),
 *     @OA\Property(property="qtd_estoque_item_eti", type="integer", description="Quantidade do Item em Estoque"),
 *     @OA\Property(
 *         property="id_estoque_eti",
 *         type="integer",
 *         description="Chave estrangeira referenciando o Estoque"
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class EstoqueItem
{
}
