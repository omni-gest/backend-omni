<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UsuarioMenu",
 *     type="object",
 *     @OA\Property(property="id_rel_usuario_menu_usm", type="integer"),
 *     @OA\Property(
 *         property="id_menu_usm",
 *         type="integer",
 *         description="Chave estrangeira referenciando o menu"
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
class UsuarioMenu
{
}
