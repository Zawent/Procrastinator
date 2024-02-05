<?php

namespace Database\Seeders;

use App\Models\Encuesta;
use Illuminate\Database\Seeder;

class EncuestaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Encuesta::create(['id'=>1, 'pregunta1'=>'Cuando te asignan una tarea con una fecha limite de entrega, esperas hasta el último minuto para hacerlo.',
        'pregunta2'=>'Es complicado para ti iniciar a trabajar, cuando sabes que tienes muchas tareas pendientes.',
        'pregunta3'=>'Sueles cancelar o cambiar de planes con tus amigos o pareja en el ultimo minuto.',
        'pregunta4'=>'Dejas abandonado un proyecto o trabajo cuando te cuesta resolverlo o entender de que trata']);
    }
}
