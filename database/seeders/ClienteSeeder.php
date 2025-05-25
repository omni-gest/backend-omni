<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_cliente')->updateOrInsert([
            'des_cliente_cli'  => 'Cliente A',
            'telefone_cliente_cli'  => '85900000000',
            'email_cliente_cli'   => 'cliente@gmail.com',
            'documento_cliente_cli'  => '78945612312',
            'endereco_cliente_cli'   => 'Rua Tal',
            'created_at' => now(),
            'updated_at' => now(),
            'id_centro_custo_cli'  => 1,

        ]);
    }
}
