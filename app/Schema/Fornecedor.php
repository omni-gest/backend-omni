<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Fornecedor",
 *     type="object",
 *     @OA\Property(property="id_fornecedor_frn", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_frn",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="desc_fornecedor_frn", type="string"),
 *     @OA\Property(property="tel_fornecedor_frn", type="string"),
 *     @OA\Property(property="documento_fornecedor_frn", type="string"),
 *     @OA\Property(property="is_ativo_frn", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Fornecedor
{
}
