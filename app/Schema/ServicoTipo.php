<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ServicoTipo",
 *     type="object",
 *     @OA\Property(property="id_servico_tipo_stp", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_stp",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="des_servico_tipo_stp", type="string", description="Descrição do tipo de serviço"),
 *     @OA\Property(property="vlr_servico_tipo_stp", type="integer", description="Valor do tipo de serviço"),
 *     @OA\Property(property="is_ativo_stp", type="boolean", description="Indica se o tipo de serviço está ativo"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="id_centro_custo_stp",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     )
 * )
 */
class ServicoTipo
{
}
