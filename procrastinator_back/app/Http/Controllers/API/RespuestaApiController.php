<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\User;

class RespuestaApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $respuesta = Respuesta::all();
        return response()->json($respuesta,200);
    }

    public function store(Request $request)
    {
    $respuestas_usuario = Respuesta::where('id_user', $request->id_user)->count();//hacer contador para un usuario

    $respuesta = new Respuesta();
    $respuesta->id_user = $request->id_user;
    $respuesta->respuesta = $request->respuesta;
    $respuesta->id_pregunta = $request->id_pregunta;
    $respuesta->save();

    if ($respuestas_usuario >= 7) { //si ya el usuario respondio las 8 preguntas
        $suma_respuestas = Respuesta::where('id_user', $request->id_user)
            ->sum('respuesta');
        $nivel_id = $this->determinarNivel($suma_respuestas);

        Respuesta::where('id_user', $request->id_user)
            ->update(['id_nivel' => $nivel_id]);

        User::where('id', $request->id_user)// para que se guarde en la tabla user
        ->update(['nivel_id' => $nivel_id]);

        return response()->json(['respuesta' => $respuesta, 'nivel_id' => $nivel_id], 201);
    }

    return response()->json(['respuesta' => $respuesta], 201);//si no ha respondido las 8 solo mostrara null en id_nivel
}

private function determinarNivel($suma_respuestas)//la validacion para que el ID de niveles se asigne
{
    if ($suma_respuestas <= 8) {
        return 1; //nivel 1 Bajo
    } elseif ($suma_respuestas >= 9 && $suma_respuestas <= 11) {
        return 2; //nivel 2 Regular
    } elseif ($suma_respuestas >= 12 && $suma_respuestas <= 14) {
        return 3; //nivel 3 Moderado
    } elseif ($suma_respuestas >=15){
        return 4; //nivel 4 Alto
    
    }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_user)
    {
        $respuesta = Respuesta::where('id_user',$id_user)->first();
        return response()->json($respuesta,200);
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
        //
    }
}
