<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Comodin;
use App\Models\Bloqueo;

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

        // Si no hay comodines previos, establece el tiempo de generación en el tiempo actual
        $tiempo_generacion = $ultimo_comodin ? $ultimo_comodin->tiempo_generacion->addHours(50) : now();

        // Crea un nuevo comodín con el ID del bloqueo y el tiempo de generación adecuado
        Comodin::create([
            'id_bloqueo' => $id_bloqueo,
            'tiempo_generacion' => $tiempo_generacion
        ]);
    }
}
