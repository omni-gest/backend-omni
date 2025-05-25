<?php

namespace Database\Seeders;

use App\Enums\OrigemStatusEnum;
use App\Enums\StatusVendaEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_status')->updateOrInsert([
            'des_status_sts' => 'Aberta',
            'origem_sts' => OrigemStatusEnum::Venda->value,
            'status_sts' => StatusVendaEnum::Aberta->value,
            'is_ativo_sts' => true,
        ]);
        DB::table('tb_status')->updateOrInsert([
            'des_status_sts' => 'Negociando',
            'origem_sts' => OrigemStatusEnum::Venda->value,
            'status_sts' => StatusVendaEnum::Negociando->value,
            'is_ativo_sts' => true,
        ]);
        DB::table('tb_status')->updateOrInsert([
            'des_status_sts' => 'Finalizada',
            'origem_sts' => OrigemStatusEnum::Venda->value,
            'status_sts' => StatusVendaEnum::Finalizada->value,
            'is_ativo_sts' => true,
        ]);
        DB::table('tb_status')->updateOrInsert([
            'des_status_sts' => 'Cancelada',
            'origem_sts' => OrigemStatusEnum::Venda->value,
            'status_sts' => StatusVendaEnum::Cancelada->value,
            'is_ativo_sts' => true,
        ]);
    }
}
