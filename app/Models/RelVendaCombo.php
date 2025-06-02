<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RelVendaCombo extends Model
{
    use HasFactory;

    protected $table = 'rel_venda_combo';

    protected $fillable = [
        'id_combo_rvc',
        'id_venda_rvc',
        'qtd_combo_rvc',
    ];

    public static function deleteReg($id)
    {
        RelVendaCombo::where('id', $id)
            ->delete();
    }

    public static function updateReg(Int $id, $obj) {
        RelVendaCombo::where('id', $id)
        ->update($obj);
    }

    public static function getByIdVenda(Int $id_venda) {
        $materiaisVenda = RelVendaCombo::where('id_venda_rvc', $id_venda)->get();

        return $materiaisVenda->toArray();
    }

}
