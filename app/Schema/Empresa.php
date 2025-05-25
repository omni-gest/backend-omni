<?php

namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Empresa",
 *     type="object",
 *     @OA\Property(property="id_empresa_emp", type="integer"),
 *     @OA\Property(property="des_empresa_emp", type="string"),
 *     @OA\Property(property="razao_social_empresa_emp", type="string"),
 *     @OA\Property(property="cnpj_empresa_emp", type="string"),
 *     @OA\Property(property="des_endereco_emp", type="string"),
 *     @OA\Property(property="des_cidade_emp", type="string"),
 *     @OA\Property(property="des_cep_emp", type="string"),
 *     @OA\Property(property="des_tel_emp", type="string"),
 *     @OA\Property(property="lnk_whatsapp_emp", type="string"),
 *     @OA\Property(property="lnk_instagram_emp", type="string"),
 *     @OA\Property(property="lnk_facebook_emp", type="string"),
 *     @OA\Property(property="img_empresa_emp", type="string", format="binary"),
 *     @OA\Property(property="is_ativo_emp", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Empresa
{
}
