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
        $this->call([
        RolsSeeder::class, 
        NivelSeeder::class, 
        PreguntaSeeder::class, 
        UserSeeder::class,
        ConsejoSeeder::class
    ]);
    }
}
