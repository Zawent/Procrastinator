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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comodines = Comodin::all();
        return response()->json($comodines, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Obtener un comodín específico con su bloqueo y su duración
        $comodin = Comodin::with('bloqueo')->find($id);
        
        if ($comodin) {
            $duracion = $comodin->bloqueo->duracion;
            // Aquí puedes usar la duración como necesites
            
            return response()->json(['comodin' => $comodin, 'duracion' => $duracion], 200);
        } else {
            return response()->json(['mensaje' => 'Comodín no encontrado'], 404);
        }
    }

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

        $sumaTiemposBloqueo = $app->bloqueos()->sum('duracion');

        $tiempo_generacion = Carbon::now()->addHours($sumaTiemposBloqueo);
        
        $app->update(['tiempo_generacion' => $tiempo_generacion]);

        $comodin = new Comodin();
        $comodin->tiempo_generacion = $tiempo_generacion;
        $comodin->id_bloqueo = $request->id_bloqueo; // Asignar el valor de id_bloqueo proporcionado en la solicitud
        $comodin->save();
        
        return response()->json(['comodin' => $comodin, 'tiempo_generacion' => $tiempo_generacion], 201);
    }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comodin = Comodin::find($id);
        $comodin->delete();
        return response()->json(null, 204);
    }

    public function ganarComodin($id_comodin)
    {
        $comodin = Comodin::find($id_comodin);

        if (!$comodin) {
            return response()->json(['mensaje' => 'No tienes comodines disponibles'], 404);
        }

        $tiempoGeneracion = Carbon::createFromTimestamp($comodin->tiempo_generacion);
        $tiempoTranscurrido = Carbon::now()->diffInHours($tiempoGeneracion);

        if ($tiempoTranscurrido >= 50) {
            $comodin->update(['tiempo_generacion' => Carbon::now()->timestamp]);
            return response()->json(['mensaje' => 'Comodín ganado con éxito']);
        } else {
            return response()->json(['mensaje' => 'Aún no han pasado 50 horas desde el último comodín']);
        }
        
    }
}
