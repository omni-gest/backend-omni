<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_unidade')->updateOrInsert([
            'des_unidade_und'  => 'Unidade',
            'des_reduz_unidade_und'  => 'UN',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_und'  => 1,
        ]);
        DB::table('tb_unidade')->updateOrInsert([
            'des_unidade_und'  => 'Quilo',
            'des_reduz_unidade_und'  => 'Kg',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_und'  => 2,
        ]);
        DB::table('tb_unidade')->updateOrInsert([
            'des_unidade_und'  => 'Litros',
            'des_reduz_unidade_und'  => 'L',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_und'  => 1,
        ]);
    }
}
