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
        return response()->json($comodines,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comodin = Comodin::find();
        return response()->json($comodin,200);
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
        return response()->json(null,204);
    }
    

    use Carbon\Carbon;

    // ...
    
    public function ganarComodin($id_comodin) {
        $comodin = Comodin::find($id_comodin);
        
        if (!$comodin) {
            return response()->json(['mensaje' => 'No tienes comodines disponibles'], 404);
        }
    
        $tiempoGeneracion = Carbon::parse($comodin->tiempo_generacion);
        $tiempoLimite = $tiempoGeneracion->addHours(50);
    
        if (now()->gte($tiempoLimite)) {
    
            $comodin->update(['tiempo_generacion' => Carbon::now()->toDateTimeString()]); 
            return response()->json(['mensaje' => 'Comodín ganado con éxito']); 
        } else {
            return response()->json(['mensaje' => 'Aún no han pasado 50 horas desde el último comodín']);
        }
    }
    
}