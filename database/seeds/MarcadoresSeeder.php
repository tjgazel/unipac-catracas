<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marcadores')->truncate();

        DB::table('marcadores')->insert([
            'nome' => 'Dia não letivo',
            'classe' => 'bg-white text-dark',
            'intervalos' => '0',
            'aula_normal' => '0',
            'repor' => '0'
        ]);

        DB::table('marcadores')->insert([
            'nome' => 'Dia letivo',
            'classe' => 'bg-info text-white',
            'intervalos' => '0',
            'aula_normal' => '1',
            'repor' => '0'
        ]);

        DB::table('marcadores')->insert([
            'nome' => 'Reposição',
            'classe' => 'bg-warning text-dark',
            'intervalos' => '0',
            'aula_normal' => '0',
            'repor' => '1'
        ]);

        DB::table('marcadores')->insert([
            'nome' => 'Intervalos',
            'classe' => 'bg-success text-white',
            'intervalos' => '1',
            'aula_normal' => '0',
            'repor' => '0'
        ]);

        DB::table('marcadores')->insert([
            'nome' => 'Feriado',
            'classe' => 'bg-dark text-white',
            'intervalos' => '0',
            'aula_normal' => '0',
            'repor' => '0'
        ]);
    }
}
