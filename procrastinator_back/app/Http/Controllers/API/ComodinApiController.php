<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comodin;
use App\Models\Bloqueo;
use App\Models\App; 

class ComodinApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comodin = Comodin::all();
        return response()->json($comodin,200);
    }

     
    public function store(Request $request)
    {
        $app = App::find($request->id_app);

        if (!$app) {
            return response()->json(['mensaje' => 'La aplicación no existe'], 404);
        }

        //  limite de 3 comodines
        $numComodines = Comodin::where('id_user', $request->id_user)->count();
        if ($numComodines >= 3) {
            return response()->json(['mensaje' => 'No puedes ganar más de 3 comodines'], 400);
        }

        //la suma de los tiempos de bloqueo de la aplicación
        $sumaTiemposBloqueo = Bloqueo::where('id_app', $app->id)->sum('duracion');

        //suma de los tiempos de bloqueo es igual o mayor a 48 horas
        if ($sumaTiemposBloqueo >= 48) {
            $tiempo_generacion = date('H:i:s'); //formato que toca usar en vez de carbon

            // guarda el tiempo de generación en la aplicación
            $comodin->tiempo_generacion = $tiempo_generacion;
            $comodin->save();

            //  creacion del comodin
            $comodin = new Comodin();
            $comodin->tiempo_generacion = $tiempo_generacion;
            $comodin->id_bloqueo = $request->id_bloqueo; 
            $comodin->id_user = $request->id_user;
            $comodin->save();

            return response()->json(['comodin' => $comodin, 'tiempo_generacion' => $tiempo_generacion], 201);
        } else {
            return response()->json(['mensaje' => 'La suma de los tiempos de bloqueo debe ser igual o mayor a 48 horas para obtener un comodín.'], 400);
        }
         }

        public function ganarComodin($id_comodin)
    {
        $comodin = Comodin::find($id_comodin);

        if (!$comodin) {
            return response()->json(['mensaje' => 'No existe el comodín.'], 404);
        }

        //  si han pasado 48 horas desde el último comodín
        $tiempoGeneracion = $comodin->tiempo_generacion;
        $tiempoTranscurrido = strtotime('now') - strtotime($tiempoGeneracion);

        if ($tiempoTranscurrido >= 48 * 3600) { // aqui se convierte las 48h en segundos
        
            $comodin->update(['tiempo_generacion' => date('H:i:s')]);
            return response()->json(['mensaje' => 'Comodín ganado con éxito'], 200);
        } else {
            return response()->json(['mensaje' => 'Aún no has cumplido con el tiempo para ganar un comodin'], 400);
        }

    }
    }
