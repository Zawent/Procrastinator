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
        $bloqueo = Bloqueo::first();
        if (!$bloqueo) {
            return;
        }

        $ultimo_comodin = Comodin::latest()->first();
        if (!$ultimo_comodin) {
            Comodin::create([
                'id_bloqueo' => $bloqueo->id,
                'tiempo_generacion' => now()->toTimeString() 
            ]);
            return;
        }

        $numComodines = Comodin::where('id_bloqueo', $bloqueo->id)->count();
        if ($numComodines >= 3) {
            return;
        }

        $tiempo_generacion = $ultimo_comodin->tiempo_generacion->addHours(48);

        Comodin::create([
            'id_bloqueo' => $bloqueo->id,
            'tiempo_generacion' => $tiempo_generacion->toTimeString()
        ]);
    }
}
