<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialMovimentacaoItem extends Model
{
    use HasFactory;
    protected $table = "tb_material_movimentacao_item";

    protected $fillable = [
        'id_movimentacao_mit',
        'id_material_mit',
        'qtd_material_mit',
        'is_ativo_mit',
        'tipo_movimentacao_mit'
    ];
}
