<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelServicoMaterial extends Model
{
    use HasFactory;

    protected $table = 'rel_servico_material';

    protected $fillable = [
        'id_servico_rsm',
        'id_material_rsm',
        'vlr_material_rsm',
        'qtd_material_rsm'
    ];
}
