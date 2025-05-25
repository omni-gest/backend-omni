<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_servico_tipo')->updateOrInsert([
            'des_servico_tipo_stp'  => 'Corte',
            'vlr_servico_tipo_stp'  => '3000',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_stp'  => 1,
        ]);
        DB::table('tb_servico_tipo')->updateOrInsert([
            'des_servico_tipo_stp'  => 'Barba',
            'vlr_servico_tipo_stp'  => '3500',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_stp'  => 2,
        ]);
        DB::table('tb_servico_tipo')->updateOrInsert([
            'des_servico_tipo_stp'  => 'Platinado',
            'vlr_servico_tipo_stp'  => '5500',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_stp'  =>1,
        ]);
        DB::table('tb_servico_tipo')->updateOrInsert([
            'des_servico_tipo_stp'  => 'Degradê',
            'vlr_servico_tipo_stp'  => '4500',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_stp'  => 2,
        ]);
    }
}
