<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaTipoServico extends Model
{
    use HasFactory;

    protected $table = 'rel_servico_agenda_tipo_servico';

    protected $fillable = [
        'id_agenda_rat',
        'id_tipo_servico_rat',
        'vlr_tipo_servico_rat'
    ];

}



