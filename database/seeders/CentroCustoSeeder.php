<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroCustoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_centro_custo')->updateOrInsert([
            'des_centro_custo_cco'  => 'Salão G Beauty',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tb_centro_custo')->updateOrInsert([
            'des_centro_custo_cco'  => 'Salão G Barber',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
