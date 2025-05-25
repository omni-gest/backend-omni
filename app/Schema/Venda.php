<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Venda",
 *     type="object",
 *     @OA\Property(property="id_venda_vda", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_vda",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(
 *         property="id_funcionario_vda",
 *         type="integer",
 *         description="Chave estrangeira referenciando o funcionário responsável pela venda"
 *     ),
 *     @OA\Property(
 *         property="id_centro_custo_vda",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     ),
 *     @OA\Property(property="desc_venda_vda", type="string", description="Descrição da venda"),
 *     @OA\Property(property="is_deleted", type="boolean", description="Indica se a venda foi deletada"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de criação"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data de atualização"),
 *     @OA\Property(
 *         property="id_cliente_vda",
 *         type="integer",
 *         description="Chave estrangeira referenciando o cliente"
 *     ),
 *     @OA\Property(
 *         property="id_status_vda",
 *         type="integer",
 *         description="Chave estrangeira referenciando o status da venda"
 *     ),
 *     @OA\Property(
 *         property="id_movimentacao_vda",
 *         type="integer",
 *         description="Chave estrangeira referenciando a movimentação da venda"
 *     )
 * )
 */
class Venda
{
}
