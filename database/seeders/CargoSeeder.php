<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_cargos')->updateOrInsert([
            'desc_cargo_tcg'  => 'Barbeiro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tb_cargos')->updateOrInsert([
            'desc_cargo_tcg'  => 'Cabeleireira',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tb_cargos')->updateOrInsert([
            'desc_cargo_tcg'  => 'Recepção',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
