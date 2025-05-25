<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_funcionarios')->updateOrInsert([
            'id_funcionario_cargo_tfu'=>1,
            'desc_funcionario_tfu'=>'João',
            'telefone_funcionario_tfu'=>'85900000000',
            'documento_funcionario_tfu'=>'200000',
            'endereco_funcionario_tfu'=>'Rua XYZ',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_tfu'  => 1,
        ]);
        DB::table('tb_funcionarios')->updateOrInsert([
            'id_funcionario_cargo_tfu'=>1,
            'desc_funcionario_tfu'=>'Pedro',
            'telefone_funcionario_tfu'=>'85900000000',
            'documento_funcionario_tfu'=>'200000',
            'endereco_funcionario_tfu'=>'Rua XYZ',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_tfu'  => 2,
        ]);
        DB::table('tb_funcionarios')->updateOrInsert([
            'id_funcionario_cargo_tfu'=>3,
            'desc_funcionario_tfu'=>'Marcos',
            'telefone_funcionario_tfu'=>'85900000000',
            'documento_funcionario_tfu'=>'200000',
            'endereco_funcionario_tfu'=>'Rua XYZ',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_tfu'  => 1,
        ]);
    }
}
