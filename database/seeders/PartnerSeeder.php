<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')->insert([
            'nome' => 'HERA DESIGN',
            'contato' => 'OTAVIO / NOSLEN',
            'cidade_id' => 1,
            'person_type_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('partners')->insert([
            'nome' => 'DESIGN ARQUITETURA',
            'contato' => 'RENATA',
            'cidade_id' => 1,
            'person_type_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('partners')->insert([
            'nome' => 'PATRICIA SIQUEIRA DESIGN',
            'contato' => 'PATRICIA',
            'cidade_id' => 1,
            'person_type_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
