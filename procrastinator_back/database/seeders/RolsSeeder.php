<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Rol::create(['id'=>1, 'nombre'=>'Super User']);
        Rol::create(['id'=>2, 'nombre'=>'User']);

    }
}
