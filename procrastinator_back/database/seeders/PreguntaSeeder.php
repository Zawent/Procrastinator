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
        Pregunta::create(['id'=>1,'descripcion_pregunta'=>'Cuando te asignan una tarea con una fecha limite de entrega, esperas hasta el último minuto para hacerlo.']);
        Pregunta::create(['id'=>2,'descripcion_pregunta'=>'Es complicado para ti iniciar a trabajar, cuando sabes que tienes muchas tareas pendientes.']);
        Pregunta::create(['id'=>3,'descripcion_pregunta'=>'Sueles cancelar o cambiar de planes con tus amigos o pareja en el ultimo minuto.']);
        Pregunta::create(['id'=>4,'descripcion_pregunta'=>'Dejas abandonado un proyecto o trabajo cuando te cuesta resolverlo o entender de que trata']);
    }
}
