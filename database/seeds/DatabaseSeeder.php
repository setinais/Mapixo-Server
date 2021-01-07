<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        \App\Classificacao::create([
            'nome' => 'Metal'
        ]);
        \App\Classificacao::create([
            'nome' => 'Plástico'
        ]);
        \App\Classificacao::create([
            'nome' => 'Papel'
        ]);
        \App\Classificacao::create([
            'nome' => 'Vidro'
        ]);
        \App\User::create([
            'name' => 'Vinnicyus',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$AGEMX8CLKsiCfTNt3NXoNewQvEqyloVwflTXCtVGT6r2eia/UKZkC',
            'telefone' => '63999878410',
            'created_at' => now()
        ]);
//        ['Kg', 'g', 'V','L', 'ml'])->default('Kg')
        \App\UnidadeMedida::create(['nome' => 'Kg','created_at' => now()]);
        \App\UnidadeMedida::create(['nome' => 'g','created_at' => now()]);
        \App\UnidadeMedida::create(['nome' => 'V','created_at' => now()]);
        \App\UnidadeMedida::create(['nome' => 'L','created_at' => now()]);
        \App\UnidadeMedida::create(['nome' => 'ml','created_at' => now()]);
    }
}
