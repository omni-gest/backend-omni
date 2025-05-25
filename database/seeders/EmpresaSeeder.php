<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_empresa')->updateOrInsert([
            'des_empresa_emp' => 'Empresa Default',
            'razao_social_empresa_emp' => 'Razão Social Default',
            'cnpj_empresa_emp' => '00.000.000/0000-00',
            'des_endereco_emp' => 'Rua Tal',
            'des_cidade_emp' => 'Fortaleza',
            'des_cep_emp' => '60789941',
            'des_tel_emp' => '911112222',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
