<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContaCorrenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contas_correntes')->insert([
            'titular' => 'HERA DESIGN',
            'banco' => 'CAIXA INTERNO',
            'agencia' => '1',
            'conta' => '1',
            'saldo_inicial' => 0,
            'saldo_atual' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('contas_correntes')->insert([
            'titular' => 'HERA DESIGN',
            'banco' => 'BANCO C6 S.A.',
            'agencia' => '0001',
            'conta' => '18410383-5',
            'saldo_inicial' => 0,
            'saldo_atual' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('contas_correntes')->insert([
            'titular' => 'HERA DESIGN - PERMUTAS',
            'banco' => 'PERMUTAS',
            'agencia' => '0001',
            'conta' => '0001',
            'saldo_inicial' => 0,
            'saldo_atual' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
