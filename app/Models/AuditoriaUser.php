<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaUser extends Model
{
    protected $table = 'tb_auditoria_user';

    protected $fillable = [
        'modelo',
        'registro_id',
        'usuario_id',
        'evento',
        'valores_anteriores',
        'valores_novos',
        'url',
        'rota',
        'metodo',
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_novos' => 'array',
    ];
}
