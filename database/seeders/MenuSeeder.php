<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => null,
            'des_menu_mnu'  => 'Home',
            'icon_menu_mnu' => 'House',
            'path_menu_mnu' => '/',
            'num_ordem_mnu' => 1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Serviço',
            'icon_menu_mnu' => 'Scissors',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 2+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 2,
            'des_menu_mnu' => 'Novo Serviço',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/servico/novo',
            'num_ordem_mnu' => 3+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 2,
            'des_menu_mnu' => 'Finalizar Serviço',
            'icon_menu_mnu' => 'CheckSquareOffset',
            'path_menu_mnu' => '/servico/finalizar',
            'num_ordem_mnu' => 4+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 2,
            'des_menu_mnu' => 'Dashboard',
            'icon_menu_mnu' => 'ChartLine',
            'path_menu_mnu' => '/servico/dashboard',
            'num_ordem_mnu' => 5+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Almoxarifado',
            'icon_menu_mnu' => 'DropboxLogo',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 6+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 6,
            'des_menu_mnu' => 'Consulta Estoque',
            'icon_menu_mnu' => 'MagnifyingGlass',
            'path_menu_mnu' => '/almoxarifado/consulta-estoque',
            'num_ordem_mnu' => 7+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 6,
            'des_menu_mnu' => 'Baixa de Entrada',
            'icon_menu_mnu' => 'ArrowDown',
            'path_menu_mnu' => '/almoxarifado/baixa/entrada',
            'num_ordem_mnu' => 8+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 6,
            'des_menu_mnu' => 'Baixa de Saída',
            'icon_menu_mnu' => 'ArrowUp',
            'path_menu_mnu' => '/almoxarifado/baixa/saida',
            'num_ordem_mnu' => 9+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 6,
            'des_menu_mnu' => 'Relatório de Movimentações',
            'icon_menu_mnu' => 'ChartLine',
            'path_menu_mnu' => '/almoxarifado/relatorio',
            'num_ordem_mnu' => 10+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Financeiro',
            'icon_menu_mnu' => 'Coins',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 11+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 11,
            'des_menu_mnu' => 'A Receber',
            'icon_menu_mnu' => 'ArrowDown',
            'path_menu_mnu' => '/financeiro/a-receber',
            'num_ordem_mnu' => 12+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 11,
            'des_menu_mnu' => 'A Pagar',
            'icon_menu_mnu' => 'ArrowUp',
            'path_menu_mnu' => '/financeiro/a-pagar',
            'num_ordem_mnu' => 13+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 11,
            'des_menu_mnu' => 'Relatório Financeiro',
            'icon_menu_mnu' => 'ChartLine',
            'path_menu_mnu' => '/financeiro/relatorio',
            'num_ordem_mnu' => 14+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Cadastro Base',
            'icon_menu_mnu' => 'Gear',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 15+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'Serviço',
            'icon_menu_mnu' => 'Scissors',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 16+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 16,
            'des_menu_mnu' => 'Cadastro de Tipo de Serviço',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/servico/tipo-servico',
            'num_ordem_mnu' => 17+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'Almoxarifado',
            'icon_menu_mnu' => 'DropboxLogo',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 18+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 18,
            'des_menu_mnu' => 'Cadastro de Unidade',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/almoxarifado/unidade',
            'num_ordem_mnu' => 19+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 18,
            'des_menu_mnu' => 'Cadastro de Materiais',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/almoxarifado/material',
            'num_ordem_mnu' => 20+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 18,
            'des_menu_mnu' => 'Cadastro de Estoque',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/almoxarifado/estoque',
            'num_ordem_mnu' => 21+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'Financeiro',
            'icon_menu_mnu' => 'Coins',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 22+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 22,
            'des_menu_mnu' => 'Cadastro de método de Pagamento',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/financeiro/metodo-pagamento',
            'num_ordem_mnu' => 23+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 22,
            'des_menu_mnu' => 'Cadastro de instituições de Pagamento',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/financeiro/instituicao-pagamento',
            'num_ordem_mnu' => 24+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'PERFIL',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '',
            'num_ordem_mnu' => 25+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 25,
            'des_menu_mnu' => 'Cadastro de Cargo',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/perfil/cargo',
            'num_ordem_mnu' => 26+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 25,
            'des_menu_mnu' => 'Cadastro de Funcionário',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/perfil/funcionario',
            'num_ordem_mnu' => 27+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 25,
            'des_menu_mnu' => 'Cadastro de Usuário',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/perfil/usuario',
            'num_ordem_mnu' => 28+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 25,
            'des_menu_mnu' => 'Cadastro Centro de Custo',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/perfil/centro-custo',
            'num_ordem_mnu' => 29+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 25,
            'des_menu_mnu' => 'Cadastro de Cliente',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/perfil/cliente',
            'num_ordem_mnu' => 30+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Agenda',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/agenda',
            'num_ordem_mnu' => 2,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Venda',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/venda',
            'num_ordem_mnu' => 31+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 32,
            'des_menu_mnu' => 'Vendas',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/venda',
            'num_ordem_mnu' => 1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 32,
            'des_menu_mnu' => 'Dashboard',
            'icon_menu_mnu' => 'ChartLine',
            'path_menu_mnu' => '/venda/dashboard',
            'num_ordem_mnu' => 2,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => null,
            'des_menu_mnu' => 'Empresa',
            'icon_menu_mnu' => 'Buildings',
            'path_menu_mnu' => '/empresa',
            'num_ordem_mnu' => 32+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 35,
            'des_menu_mnu' => 'Empresas',
            'icon_menu_mnu' => 'Buildings',
            'path_menu_mnu' => '/empresas',
            'num_ordem_mnu' => 1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 15,
            'des_menu_mnu' => 'Permissões',
            'icon_menu_mnu' => 'User',
            'path_menu_mnu' => '/cadastro-base/permissoes',
            'num_ordem_mnu' => 33+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 37,
            'des_menu_mnu' => 'Permissões de Usuário',
            'icon_menu_mnu' => 'User',
            'path_menu_mnu' => '/cadastro-base/permissoes/permissoes-usuario',
            'num_ordem_mnu' => 34+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 37,
            'des_menu_mnu' => 'Permissões de Empresa',
            'icon_menu_mnu' => 'Buildings',
            'path_menu_mnu' => '/cadastro-base/permissoes/permissoes-empresa',
            'num_ordem_mnu' => 35+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 37,
            'des_menu_mnu' => 'Permissões de Centro de Custo',
            'icon_menu_mnu' => 'FilePlus',
            'path_menu_mnu' => '/cadastro-base/permissoes/permissoes-centro-custo',
            'num_ordem_mnu' => 36+1,
        ]);
        DB::table('tb_menu')->updateOrInsert([
            'id_father_mnu' => 25,
            'des_menu_mnu' => 'Cadastro Origem do Cliente',
            'icon_menu_mnu' => 'TagChevron',
            'path_menu_mnu' => '/cadastro-base/perfil/origem-cliente',
            'num_ordem_mnu' => 37+1,
        ]);
    }
}
