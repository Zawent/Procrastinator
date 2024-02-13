<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();
<<<<<<< HEAD
=======

>>>>>>> f77092355fc32b4e69c399ad6d71742ae49128f0
        $this->call([
        RolsSeeder::class, 
        NivelSeeder::class, 
        PreguntaSeeder::class, 
        ComodinSeeder::class,
        UserSeeder::class,
        ConsejoSeeder::class
    ]);
<<<<<<< HEAD
=======
        $this->call([RolsSeeder::class, NivelSeeder::class, PreguntaSeeder::class, ComodinSeeder::class]);
>>>>>>> f77092355fc32b4e69c399ad6d71742ae49128f0
    }
}
