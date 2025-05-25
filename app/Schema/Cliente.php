<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Cliente",
 *     type="object",
 *     @OA\Property(property="id_cliente_cli", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_cli",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="des_cliente_cli", type="string"),
 *     @OA\Property(property="telefone_cliente_cli", type="string"),
 *     @OA\Property(property="email_cliente_cli", type="string", format="email"),
 *     @OA\Property(property="documento_cliente_cli", type="string"),
 *     @OA\Property(property="endereco_cliente_cli", type="string"),
 *     @OA\Property(property="is_ativo_cli", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="id_centro_custo_cli",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     ),
 *     @OA\Property(
 *         property="id_origem_cliente_cli",
 *         type="integer",
 *         description="Chave estrangeira referenciando a origem do cliente"
 *     )
 * )
 */
class Cliente
{
}
