<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Cargo",
 *     type="object",
 *     @OA\Property(property="id_cargo_tcg", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_tcg",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="desc_cargo_tcg", type="string"),
 *     @OA\Property(property="is_ativo_tcg", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Cargo
{
}
