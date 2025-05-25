<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SituacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_situacao')->updateOrInsert([
            'tbl_situacao_tsi'  => 'tb_servico',
            'desc_situacao_tsi'  => 'Aberto',
        ]);
        DB::table('tb_situacao')->updateOrInsert([
            'tbl_situacao_tsi'  => 'tb_servico',
            'desc_situacao_tsi'  => 'Finalizado',
        ]);
        DB::table('tb_situacao')->updateOrInsert([
            'id_situacao_tsi'  => 10,
            'tbl_situacao_tsi'  => 'tb_servico_agenda',
            'desc_situacao_tsi'  => 'Pré-Agendamento',
        ]);
        DB::table('tb_situacao')->updateOrInsert([
            'id_situacao_tsi'  => 11,
            'tbl_situacao_tsi'  => 'tb_servico_agenda',
            'desc_situacao_tsi'  => 'Agendado',
        ]);
        DB::table('tb_situacao')->updateOrInsert([
            'id_situacao_tsi'  => 12,
            'tbl_situacao_tsi'  => 'tb_servico_agenda',
            'desc_situacao_tsi'  => 'Cancelado',
        ]);
    }
}
