<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comodin;

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
        $comodin = Comodin::find($id);
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
    
    /*
    public function ganarComodin($id_app) {
        $app = App::find($id_app);
        $ultimaFechaComodin = $app->fecha_ultimo_comodin;
    
        $tiempoTranscurrido = now()->diffInHours($ultimaFechaComodin);
    
        if ($tiempoTranscurrido >= 50) {
            $app->comodines_ganados++;
            $app->fecha_ultimo_comodin = now();
            $app->save();
    
            return response()->json(['message' => 'Comodín ganado con éxito']);
        } else {
            return response()->json(['message' => 'Aún no han pasado 50 horas desde el último comodín']);
            
        }

    }
    
    
  }
  
