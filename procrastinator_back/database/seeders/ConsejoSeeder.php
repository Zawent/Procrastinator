<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consejo;

class ConsejoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Consejo::create(['id'=>1, 'id_nivel'=>1, 'consejo'=>'Establece metas claras y alcanzables: Divide tus tareas en objetivos más pequeños y concretos para hacerlas menos abrumadoras y más fáciles de abordar.']);
        Consejo::create(['id'=>2, 'id_nivel'=>1, 'consejo'=>'Recompénsate por el trabajo realizado: Motívate a ti mismo con pequeñas recompensas después de completar cada tarea. Esto refuerza hábitos productivos y te ayuda a mantener la motivación.']);
        Consejo::create(['id'=>3, 'id_nivel'=>2, 'consejo'=>'Practica el autocontrol: Aprende a reconocer y gestionar tus impulsos para procrastinar. Cultivar hábitos de autorregulación te ayudará a resistir la tentación de postergar.']);
        Consejo::create(['id'=>4, 'id_nivel'=>2, 'consejo'=>'Comienza con pequeños pasos: Si te sientes abrumado por una tarea, simplemente comienza con un pequeño paso. A menudo, dar el primer paso es lo más difícil, pero una vez que lo haces, es más fácil continuar.']);
        Consejo::create(['id'=>5, 'id_nivel'=>3, 'consejo'=>'Elimina las distracciones: Identifica y elimina cualquier cosa que pueda desviar tu atención de la tarea en cuestión, como notificaciones de teléfono o redes sociales.']);
        Consejo::create(['id'=>6, 'id_nivel'=>3, 'consejo'=>'Prioriza tus tareas: Enfócate en las tareas más importantes y urgentes primero, dejando las menos importantes para después. Esto te ayuda a gestionar mejor tu tiempo y energía.']);
        Consejo::create(['id'=>7, 'id_nivel'=>4, 'consejo'=>'Establece un horario y adhiérete a él: Crea un horario diario o semanal y trata de cumplirlo lo más posible. La consistencia te ayudará a evitar dejar las cosas para más tarde.']);
        Consejo::create(['id'=>8, 'id_nivel'=>4, 'consejo'=>'Utiliza la técnica Pomodoro: Trabaja en intervalos cortos de tiempo (por ejemplo, 25 minutos) seguidos de breves descansos. Esto te ayuda a mantener la concentración y a evitar la procrastinación.']);
    }
}
