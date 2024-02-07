<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comodin;
use App\Models\Bloqueo;
use Carbon\Carbon;

class ComodinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtén el ID del primer bloqueo disponible
        $id_bloqueo = Bloqueo::first()->id;

        // Encuentra el último comodín ganado por el usuario (asumiendo que hay uno)
        $ultimo_comodin = Comodin::latest()->first();

        // Si no hay comodines previos o ya se tienen 3 comodines, no se genera uno nuevo
        $numComodines = Comodin::where('id_bloqueo', $id_bloqueo)->count();
        if (!$ultimo_comodin || $numComodines >= 3) {
            return;
        }

        // Calcula el tiempo de generación del nuevo comodín
        $tiempo_generacion = $ultimo_comodin->tiempo_generacion->addHours(23);

        // Crea un nuevo comodín con el ID del bloqueo y el tiempo de generación adecuado
        Comodin::create([
            'id_bloqueo' => $id_bloqueo,
            'tiempo_generacion' => $tiempo_generacion
        ]);
    }
}
