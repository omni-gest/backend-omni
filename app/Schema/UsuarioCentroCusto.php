<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UsuarioCentroCusto",
 *     type="object",
 *     @OA\Property(property="id_rel_usuario_centro_custo_ccu", type="integer"),
 *     @OA\Property(
 *         property="id_centro_custo_ccu",
 *         type="integer",
 *         description="Chave estrangeira referenciando o Centro de Custo"
 *     ),
 *     @OA\Property(
 *         property="id_user",
 *         type="integer",
 *         description="Chave estrangeira referenciando o usuário"
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class UsuarioCentroCusto
{
}
