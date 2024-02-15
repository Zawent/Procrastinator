<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pregunta;

class PreguntaApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pregunta = Pregunta::all();
        return response()->json($pregunta,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //no debe haber creacion de pregunta   
    }

    public function contar(){
        $preguntas=Pregunta::all();
        return count($preguntas);

        $limite_preguntas = 7;
        $cantidad_preguntas = Pregunta::count();//contador para que al momento de crear preguntas solo sean 8
                                                //inicia en 3 por las las semillas guardadas
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pregunta = Pregunta::find($id);
        return response()->json($pregunta,200);
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
        $pregunta = Pregunta::find($id);
        $pregunta->descripcion_pregunta = $request->descripcion_pregunta;
        $pregunta->update();
        
        return response()->json($pregunta,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pregunta = Pregunta::find($id);
        $pregunta->delete();
        return response()->json($pregunta,200);
    }
}
