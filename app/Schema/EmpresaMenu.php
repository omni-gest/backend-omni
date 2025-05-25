<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="EmpresaMenu",
 *     type="object",
 *     @OA\Property(property="id_rel_empresa_menu_emn", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_emn",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(
 *         property="id_menu_emn",
 *         type="integer",
 *         description="Chave estrangeira referenciando o menu"
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class EmpresaMenu
{
}
