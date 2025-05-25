<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelServicoTipoServico extends Model
{
    use HasFactory;

    protected $table = 'rel_servico_tipo_servico';

    protected $fillable = [
        'id_servico_rst',
        'id_tipo_servico_rst',
        'vlr_tipo_servico_rst'
    ];

    public static function getTopTiposServico($centrosCusto = [], $dataInicio = null, $dataFim = null)
    {
        $query = self::query()
            ->join('tb_servico as ts', 'ts.id_servico_ser', '=', 'rel_servico_tipo_servico.id_servico_rst')
            ->join('tb_servico_tipo as tst', 'tst.id_servico_tipo_stp', '=', 'rel_servico_tipo_servico.id_tipo_servico_rst');

        if (!empty($centrosCusto)) {
            $query->whereIn('ts.id_centro_custo_ser', $centrosCusto);
        }

        if ($dataInicio && $dataFim) {
            $query->whereBetween('ts.created_at', [$dataInicio, $dataFim]);
        }

        return $query
            ->selectRaw('tst.des_servico_tipo_stp AS tipo_servico, COUNT(*) AS total_tipo_servico')
            ->groupBy('tst.id_servico_tipo_stp', 'tst.des_servico_tipo_stp')
            ->orderByDesc('total_tipo_servico')
            ->limit(7)
            ->get();
    }
}
