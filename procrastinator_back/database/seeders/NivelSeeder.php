<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nivel;

class NivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nivel::create(['id'=>1, 'descripcion'=>'Bajo']);
        Nivel::create(['id'=>2, 'descripcion'=>'Regular']);
        Nivel::create(['id'=>3, 'descripcion'=>'Moderado']);
        Nivel::create(['id'=>4, 'descripcion'=>'Alto']);
    }
}
