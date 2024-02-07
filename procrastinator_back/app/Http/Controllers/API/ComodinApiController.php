<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comodin;
use App\Models\Bloqueo;
use App\Models\App; 
use Carbon\Carbon;

class ComodinApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $app = App::find($request->id_app);

        if (!$app) {
            return response()->json(['mensaje' => 'La aplicación no existe'], 404);
        }

        //  límite de 3 comodines
        $numComodines = Comodin::where('user_id', $request->user_id)->count();
        if ($numComodines >= 3) {
            return response()->json(['mensaje' => 'El usuario ya ha alcanzado el límite de 3 comodines.'], 400);
        }

        //la suma de los tiempos de bloqueo de la aplicación
        $sumaTiemposBloqueo = Bloqueo::where('id_app', $app->id)->sum('duracion');

        //suma de los tiempos de bloqueo es igual o mayor a 23 horas
        if ($sumaTiemposBloqueo >= 23) {
            $tiempo_generacion = Carbon::now();

        // guarda el tiempo de generación en la aplicación
            $app->tiempo_generacion = $tiempo_generacion;
            $app->save();

            //  creacion del comodin
            $comodin = new Comodin();
            $comodin->tiempo_generacion = $tiempo_generacion;
            $comodin->id_bloqueo = $request->id_bloqueo; 
            $comodin->user_id = $request->user_id;
            $comodin->save();

            return response()->json(['comodin' => $comodin, 'tiempo_generacion' => $tiempo_generacion], 201);
        } else {
            return response()->json(['mensaje' => 'La suma de los tiempos de bloqueo debe ser igual o mayor a 23 horas para obtener un comodín.'], 400);
        }
    }

    /**
     * 
     *
     * @param  int  $id_comodin
     * @return \Illuminate\Http\Response
     */
    public function ganarComodin($id_comodin)
    {
        $comodin = Comodin::find($id_comodin);

        if (!$comodin) {
            return response()->json(['mensaje' => 'No existe el comodín.'], 404);
        }

        //  si han pasado 23 horas desde el último comodín
        $tiempoGeneracion = Carbon::parse($comodin->tiempo_generacion);
        $tiempoTranscurrido = Carbon::now()->diffInHours($tiempoGeneracion);

        if ($tiempoTranscurrido >= 23) {
            // Actualizar el tiempo de generación del comodín
            $comodin->update(['tiempo_generacion' => Carbon::now()]);
            return response()->json(['mensaje' => 'Comodín ganado con éxito'], 200);
        } else {
            return response()->json(['mensaje' => 'Aún no han pasado 23 horas desde el último comodín'], 400);
        }
    }
}
