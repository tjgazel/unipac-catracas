<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Giovanni Camargo',
            'cpf' => '03440019624',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'tipo_usuario' => 1,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Talles Gazel',
            'cpf' => '03616677602',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'tipo_usuario' => 1,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
