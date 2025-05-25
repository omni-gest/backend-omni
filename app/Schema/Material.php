<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Material",
 *     type="object",
 *     @OA\Property(property="id_material_mte", type="integer"),
 *     @OA\Property(
 *         property="id_unidade_mte",
 *         type="integer",
 *         description="Chave estrangeira referenciando a unidade"
 *     ),
 *     @OA\Property(
 *         property="id_empresa_mte",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="des_material_mte", type="string"),
 *     @OA\Property(property="vlr_material_mte", type="integer"),
 *     @OA\Property(property="is_ativo_mte", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="id_centro_custo_mte",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     )
 * )
 */
class Material
{
}
