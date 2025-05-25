<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Estoque",
 *     type="object",
 *     @OA\Property(property="id_estoque_est", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_est",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="des_estoque_est", type="string"),
 *     @OA\Property(
 *         property="id_centro_custo_est",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     ),
 *     @OA\Property(property="is_ativo_est", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Estoque
{
}
