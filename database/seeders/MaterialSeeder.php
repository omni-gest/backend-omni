<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_material')->updateOrInsert([
            'id_unidade_mte'=>1,
            'des_material_mte'=>'Material A',
            'vlr_material_mte'=>'1000',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_mte'  =>1,
        ]);
        DB::table('tb_material')->updateOrInsert([
            'id_unidade_mte'=>1,
            'des_material_mte'=>'Material B',
            'vlr_material_mte'=>'1250',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_mte'  =>2,
        ]);
        DB::table('tb_material')->updateOrInsert([
            'id_unidade_mte'=>1,
            'des_material_mte'=>'Material C',
            'vlr_material_mte'=>'2590',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_mte'  =>1,
        ]);
    }
}
