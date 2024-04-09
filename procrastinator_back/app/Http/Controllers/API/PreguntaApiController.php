<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pregunta;

class PreguntaApiController extends Controller
{
    /**
     * @param $request
     * @return Response
     * 
     * Este método obtiene todas las preguntas.
     */
    public function index()
    {
        $pregunta = Pregunta::all();
        return response()->json($pregunta,200);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método cuenta la cantidad de preguntas y limita su creación a 8 preguntas.
     */

     public function contar(){
        $preguntas=Pregunta::all();
        return count($preguntas);

        $limite_preguntas = 7;
        $cantidad_preguntas = Pregunta::count();
        if ($cantidad_preguntas >= $limite_preguntas) {
            return response()->json(['error' => 'Limite de preguntas creadas (8).'], 400);
        }else{
            $pregunta = new Pregunta();
            $pregunta->descripcion_pregunta = $request->descripcion_pregunta;
            $pregunta->save();
            return response()->json($pregunta,201);
        }
    }

   /**
     * @param $request
     * @return Response
     * 
     * Este método muestra las preguntas.
     */
    public function show($id)
    {
        $pregunta = Pregunta::find($id);
        return response()->json($pregunta,200);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método actualiza las preguntas.
     */

    public function update(Request $request, $id)
    {
        $pregunta = Pregunta::find($id);
        $pregunta->descripcion_pregunta = $request->descripcion_pregunta;
        $pregunta->update();
        
        return response()->json($pregunta,200);
    }
}
