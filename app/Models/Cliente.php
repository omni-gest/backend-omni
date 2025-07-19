<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = "tb_cliente";

    protected $fillable = [
        'des_cliente_cli',
        'telefone_cliente_cli',
        'email_cliente_cli',
        'documento_cliente_cli',
        'endereco_cliente_cli',
        'id_centro_custo_cli',
        'is_ativo_cli',
        'id_empresa_cli',
        'id_origem_cliente_cli',
    ];

    public static function getAll($id_empresa, $queryParams)
    {
        $paginator = Cliente::select('tb_cliente.*', 'tb_centro_custo.des_centro_custo_cco', 'tb_origem_cliente.desc_origem_cliente_orc')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_cliente.id_centro_custo_cli')
            ->join('tb_origem_cliente', 'tb_origem_cliente.id_origem_cliente_orc', '=', 'tb_cliente.id_origem_cliente_cli')
            ->where('is_ativo_cli', 1)
            ->where(function ($query) use ($queryParams) {
                $filter = $queryParams->filter;
                $query->where('des_cliente_cli', 'like', "%$filter%")
                    ->orWhere('telefone_cliente_cli', 'like', "%$filter%");
            })
            ->when($queryParams->id_centro_custo_cli, function ($query, $id_centro_custo_cli) {
                return $query->where('tb_cliente.id_centro_custo_cli', $id_centro_custo_cli);
            })
            ->where('id_empresa_cli', $id_empresa)
            ->orderBy('id_cliente_cli', 'desc')
            ->paginate($queryParams->perPage, ['*'], 'page', $queryParams->pageNumber);

        return response()->json([
            'items' => $paginator->items(),
            'total' => $paginator->total(),
        ]);
    }

    public static function getById(int $id_cliente, int $id_empresa)
    {

        $data = Cliente::select('tb_cliente.*', 'tb_centro_custo.des_centro_custo_cco', 'tb_origem_cliente.desc_origem_cliente_orc')
            ->join('tb_centro_custo', 'tb_centro_custo.id_centro_custo_cco', '=', 'tb_cliente.id_centro_custo_cli')
            ->join('tb_origem_cliente', 'tb_origem_cliente.id_origem_cliente_orc', '=', 'tb_cliente.id_origem_cliente_cli')
            ->where('id_cliente_cli', $id_cliente)
            ->where('id_empresa_cli', $id_empresa)
            ->where('is_ativo_cli', 1)
            ->first();

        return $data;
    }

    public static function updateReg(int $id_empresa, int $id_cliente, $dados_atualizados)
    {
        Cliente::
            where('id_cliente_cli', $id_cliente)
            ->where('id_empresa_cli', $id_empresa)
            ->update($dados_atualizados);
    }

    public static function deleteReg($id_empresa, $id_cliente)
    {
        Cliente::
            where('id_cliente_cli', $id_cliente)
            ->where('id_empresa_cli', $id_empresa)
            ->update([
                'is_ativo_cli' => 0
            ]);
    }

}
