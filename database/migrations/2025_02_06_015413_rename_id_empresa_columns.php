<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tables = [
        ['name' => 'tb_cargos', 'id' => 'id_cargo_tcg'],
        ['name' => 'tb_centro_custo', 'id' => 'id_centro_custo_cco'],
        ['name' => 'tb_cliente', 'id' => 'id_cliente_cli'],
        ['name' => 'tb_conta', 'id' => 'id_conta_con'],
        ['name' => 'tb_conta_tipo', 'id' => 'id_conta_tipo_ctp'],
        ['name' => 'tb_estoque', 'id' => 'id_estoque_est'],
        ['name' => 'tb_fornecedor', 'id' => 'id_fornecedor_Frn'],
        ['name' => 'tb_funcionarios', 'id' => 'id_funcionario_tfu'],
        ['name' => 'tb_instituicao_pagamento', 'id' => 'id_instituicao_pagamento_tip'],
        ['name' => 'tb_material', 'id' => 'id_unidade_mte'],
        ['name' => 'tb_material_movimentacao', 'id' => 'id_movimentacao_mov'],
        ['name' => 'tb_material_movimentacao_item', 'id' => 'id_movimentacao_mit'],
        ['name' => 'tb_menu', 'id' => 'id_menu_mnu'],
        ['name' => 'tb_metodo_pagamento', 'id' => 'id_metodo_pagamento_tmp'],
        ['name' => 'tb_servico', 'id' => 'id_servico_ser'],
        ['name' => 'tb_servico_agenda', 'id' => 'id_agenda_age'],
        ['name' => 'tb_servico_tipo', 'id' => 'id_servico_tipo_stp'],
        ['name' => 'tb_situacao', 'id' => 'id_situacao_tsi'],
        ['name' => 'tb_unidade', 'id' => 'id_unidade_und'],
        ['name' => 'tb_venda', 'id' => 'id_venda_vda'],
        ['name' => 'tb_auditoria', 'id' => 'id_auditoria_aud'],
        ['name' => 'users', 'id' => 'id'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $schemaTable) {
            $idColumn = $schemaTable['id'];
            $suffix = substr($idColumn, strrpos($idColumn, '_') + 1);
            $empresaColumn = "id_empresa_$suffix";

            if (!Schema::hasColumn($schemaTable['name'], $empresaColumn)) {
                Schema::table($schemaTable['name'], function (Blueprint $table) use ($empresaColumn, $idColumn) {
                    $table->unsignedBigInteger($empresaColumn)->default(1)->after($idColumn);
                    $table->foreign($empresaColumn)->references('id_empresa_emp')->on('tb_empresa')->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $schemaTable) {
            $idColumn = $schemaTable['id'];
            $suffix = substr($idColumn, strrpos($idColumn, '_') + 1);
            $empresaColumn = "id_empresa_$suffix";

            if (!Schema::hasColumn($schemaTable['name'], $empresaColumn)) {
                Schema::table($schemaTable['name'], function (Blueprint $table) use ($empresaColumn, $schemaTable) {
                    $table->dropForeign($schemaTable['name'] . '_' . $empresaColumn . '_foreign');
                    $table->dropColumn($empresaColumn);
                });
            }
        }
    }
};
