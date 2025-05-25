<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="MetodoPagamento",
 *     type="object",
 *     @OA\Property(property="id_metodo_pagamento_tmp", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_tmp",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="desc_metodo_pagamento_tmp", type="string"),
 *     @OA\Property(
 *         property="is_ativo_tmp",
 *         type="boolean",
 *         description="Indica se o método de pagamento está ativo"
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class MetodoPagamento
{
}
