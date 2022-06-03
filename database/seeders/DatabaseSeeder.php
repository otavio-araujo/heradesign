<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Otávio Araújo',
            'email' => 'admin@heradesign.test',
            'password' => bcrypt('password'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->call([
            EstadoSeeder::class,
            CidadeSeeder::class,
            SupplierSeeder::class,
            FeedstockSeeder::class,
            PartnerSeeder::class,
            PersonTypeSeeder::class,
        ]);
    }
}
