<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="InstituicaoPagamento",
 *     type="object",
 *     @OA\Property(property="id_instituicao_pagamento_tip", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_tip",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="desc_instituicao_pagamento_tip", type="string"),
 *     @OA\Property(property="is_ativo_tip", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class InstituicaoPagamento
{
}
