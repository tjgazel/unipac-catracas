<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // mysql
        DB::statement('PRAGMA foreign_keys = OFF;'); // sqlite

        $this->call(UsersTableSeeder::class);

//        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // mysql
        DB::statement('PRAGMA foreign_keys = ON;'); //sqlite
    }
}
