<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['id'=>1, 'name'=>'superuser', 'fecha_nacimiento'=>'1999-02-10', 'ocupacion'=>'estudiante', 'email'=>'pruebasuper@gmail.com', 'password'=>bcrypt('12345678'), 'id_rol'=>1]);
        User::create(['id'=>2, 'name'=>'user', 'fecha_nacimiento'=>'1999-02-10', 'ocupacion'=>'estudiante', 'email'=>'prueba@gmail.com', 'password'=>bcrypt('12345678'), 'id_rol'=>2]);
    }
}
