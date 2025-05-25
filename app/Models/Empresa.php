<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'tb_empresa';

    protected $fillable = [
        'des_empresa_emp',
        'razao_social_empresa_emp',
        'cnpj_empresa_emp',
        'des_endereco_emp',
        'des_cidade_emp',
        'des_cep_emp',
        'des_tel_emp',
        'lnk_whatsapp_emp',
        'lnk_instagram_emp',
        'lnk_facebook_emp',
        'img_empresa_emp'
    ];

    public static function getAll(String $filter, $perPage = 10, Int $pageNumber = 1,) {
        $paginator = Empresa::select([
            'id_empresa_emp',
            'des_empresa_emp',
            'razao_social_empresa_emp',
            'cnpj_empresa_emp',
            'des_endereco_emp',
            'des_cidade_emp',
            'des_cep_emp',
            'des_tel_emp',
            'lnk_whatsapp_emp',
            'lnk_instagram_emp',
            'lnk_facebook_emp',
            'img_empresa_emp',
        ])
        ->where('tb_empresa.des_empresa_emp', 'like', '%'.$filter.'%')
        ->orderBy('tb_empresa.id_empresa_emp', 'desc')
        ->paginate($perPage, ['*'], 'page', $pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function findByCodigo($codigo) {
        $data = Empresa::select(['*'])->where('cod_empresa_emp', $codigo)->where('is_ativo_emp', 1)->get();
        return $data;
    }

    public static function updateReg($id_empresa_emp, $obj) {
        Empresa::
        where('id_empresa_emp', $id_empresa_emp)
        ->update($obj);
    }

    public static function validateCNPJ($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (in_array($cnpj, [
            '00000000000000', '11111111111111', '22222222222222',
            '33333333333333', '44444444444444', '55555555555555',
            '66666666666666', '77777777777777', '88888888888888',
            '99999999999999'
        ])) {
            return false;
        }

        $sum1 = 0;
        $sum2 = 0;
        $multipliers1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $multipliers2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 12; $i++) {
            $sum1 += $cnpj[$i] * $multipliers1[$i];
        }

        $digit1 = ($sum1 % 11) < 2 ? 0 : 11 - ($sum1 % 11);

        for ($i = 0; $i < 13; $i++) {
            $sum2 += $cnpj[$i] * $multipliers2[$i];
        }

        $digit2 = ($sum2 % 11) < 2 ? 0 : 11 - ($sum2 % 11);

        return $cnpj[12] == $digit1 && $cnpj[13] == $digit2;
    }
}
