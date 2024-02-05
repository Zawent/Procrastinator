<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comodin;

class ComodinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comodin::create(['id'=> 1, 'tiempo_generacion'=> '50:00:00',]);

    }
}
