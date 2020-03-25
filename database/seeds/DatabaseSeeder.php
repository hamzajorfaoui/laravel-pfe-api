<?php

use Illuminate\Database\Seeder;
use App\Semestre;
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


    Semestre::create(['name'=> "S1"]);
    Semestre::create(['name'=> "S2"]);
    Semestre::create(['name'=> "S3"]);
    Semestre::create(['name'=> "S4"]);
    Semestre::create(['name'=> "S5"]);
    Semestre::create(['name'=> "S6"]);


    }
}
