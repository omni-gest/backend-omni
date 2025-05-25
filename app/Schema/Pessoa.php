<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Pessoa",
 *     type="object",
 *     @OA\Property(property="id_pessoa_pes", type="integer"),
 *     @OA\Property(
 *         property="id_centro_custo_pes",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     ),
 *     @OA\Property(property="nome_pessoa_pes", type="string"),
 *     @OA\Property(property="documento_pessoa_pes", type="string"),
 *     @OA\Property(property="is_ativo_pes", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Pessoa
{
}
