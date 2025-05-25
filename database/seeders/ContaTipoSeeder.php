<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContaTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_conta_tipo')->updateOrInsert([
            'des_conta_tipo_ctp'  => 'entrada',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tb_conta_tipo')->updateOrInsert([
            'des_conta_tipo_ctp'  => 'saida',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
