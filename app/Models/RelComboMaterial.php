<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelComboMaterial extends Model
{
    use HasFactory;

    protected $table = "rel_combo_material";

    protected $primaryKey = 'id_combo_material_cbm';

    protected $fillable = [
        'id_combo_cbm',
        'id_material_cbm',
        'documento_pessoa_pes'
    ];
}
