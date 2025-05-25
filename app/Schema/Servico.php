<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Servico",
 *     type="object",
 *     @OA\Property(property="id_servico_ser", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_ser",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="txt_servico_ser", type="string"),
 *     @OA\Property(property="vlr_servico_ser", type="integer", description="Valor do serviço"),
 *     @OA\Property(property="dta_agendamento_ser", type="string", format="date-time", description="Data de agendamento do serviço"),
 *     @OA\Property(
 *         property="id_situacao_ser",
 *         type="integer",
 *         description="Chave estrangeira referenciando a situação do serviço"
 *     ),
 *     @OA\Property(
 *         property="id_funcionario_servico_ser",
 *         type="integer",
 *         description="Chave estrangeira referenciando o funcionário responsável pelo serviço"
 *     ),
 *     @OA\Property(
 *         property="id_centro_custo_ser",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     ),
 *     @OA\Property(
 *         property="id_cliente_ser",
 *         type="integer",
 *         description="Chave estrangeira referenciando o cliente"
 *     ),
 *     @OA\Property(property="is_ativo_ser", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Servico
{
}
