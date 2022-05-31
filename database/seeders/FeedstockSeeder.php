<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeedstockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('feedstocks')->insert([
            'nome' => 'MDF 6MM',
            'unidade_medida' => 'CHAPA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('feedstocks')->insert([
            'nome' => 'TECIDO FACTO - DUNNAS - FENDI',
            'unidade_medida' => 'METRO',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('feedstocks')->insert([
            'nome' => 'TECIDO SUEDE',
            'unidade_medida' => 'METRO',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('feedstocks')->insert([
            'nome' => 'ESPUMA D26 - 3CM',
            'unidade_medida' => 'M³',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('feedstocks')->insert([
            'nome' => 'COLA DE CONTATO',
            'unidade_medida' => 'LATA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

    }
}
