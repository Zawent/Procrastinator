<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pregunta;


class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pregunta::create(['id'=>1,'descripcion_pregunta'=>'¿Postergas tareas importantes con frecuencia?']);
        Pregunta::create(['id'=>2,'descripcion_pregunta'=>'¿Sueles esperar hasta el último minuto para completar tus responsabilidades?']);
        Pregunta::create(['id'=>3,'descripcion_pregunta'=>'¿Te resulta difícil empezar una tarea incluso si es importante? ']);
        Pregunta::create(['id'=>4,'descripcion_pregunta'=>'¿Encuentras excusas para evitar hacer algo que sabes que deberías hacer?']);
        Pregunta::create(['id'=>5,'descripcion_pregunta'=>'¿Te distraes fácilmente cuando intentas trabajar en algo?']);
        Pregunta::create(['id'=>6,'descripcion_pregunta'=>'¿Sientes que tienes tiempo más que suficiente para hacer las cosas después?']);
        Pregunta::create(['id'=>7,'descripcion_pregunta'=>'¿A menudo te encuentras posponiendo metas a largo plazo?']);
        Pregunta::create(['id'=>8,'descripcion_pregunta'=>'¿Te sientes abrumado por la cantidad de cosas que debes hacer?']);

    }
}
