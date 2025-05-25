<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Unidade",
 *     type="object",
 *     @OA\Property(property="id_unidade_und", type="integer"),
 *     @OA\Property(
 *         property="id_empresa_und",
 *         type="integer",
 *         description="Chave estrangeira referenciando a empresa"
 *     ),
 *     @OA\Property(property="des_unidade_und", type="string", description="Descrição completa da unidade"),
 *     @OA\Property(property="des_reduz_unidade_und", type="string", description="Descrição reduzida da unidade"),
 *     @OA\Property(
 *         property="id_centro_custo_und",
 *         type="integer",
 *         description="Chave estrangeira referenciando o centro de custo"
 *     ),
 *     @OA\Property(property="is_ativo_und", type="boolean", description="Indica se a unidade está ativa"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de criação do registro"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data da última atualização do registro")
 * )
 */
class Unidade
{
}
