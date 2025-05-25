<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Funcionario",
 *     type="object",
 *     @OA\Property(property="id_funcionario_tfu", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_tfu",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(
 *         property="id_funcionario_cargo_tfu",
 *         type="integer",
 *         description="Chave estrangeira referenciando o cargo do funcionário"
 *     ),
 *     @OA\Property(property="desc_funcionario_tfu", type="string"),
 *     @OA\Property(property="telefone_funcionario_tfu", type="string"),
 *     @OA\Property(property="documento_funcionario_tfu", type="string"),
 *     @OA\Property(property="endereco_funcionario_tfu", type="string"),
 *     @OA\Property(property="is_ativo_tfu", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="id_centro_custo_tfu",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     )
 * )
 */
class Funcionario
{
}
