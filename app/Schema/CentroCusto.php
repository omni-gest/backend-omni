<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CentroCusto",
 *     type="object",
 *     @OA\Property(property="id_centro_custo_cco", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_cco", 
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="des_centro_custo_cco", type="string"),
 *     @OA\Property(property="is_ativo_cco", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class CentroCusto
{
}
