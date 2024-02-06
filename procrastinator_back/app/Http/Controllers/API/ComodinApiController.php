<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comodin;
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
        $comodin = Comodin::find($id);
        return response()->json($comodin, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
