<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\User;

class RespuestaApiController extends Controller
{
    /**
     * @param $request
     * @return Response
     * 
     * Este método obtiene todas las respuestas.
     */
    public function index()
    {
        $respuesta = Respuesta::all();
        return response()->json($respuesta,200);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método hace un contador de respuestas según el id de usuario,
     * y crea respuestas con los datos dados, si el usuarios responde 8 preguntas
     * determina su nivel y se guarda en la tabla user, si no, se mostrará null su id nivel.
     */

    public function store(Request $request)
    {
    $respuestas_usuario = Respuesta::where('id_user', $request->id_user)->count();
    $respuesta = new Respuesta();
    $respuesta->id_user = $request->id_user;
    $respuesta->respuesta = $request->respuesta;
    $respuesta->id_pregunta = $request->id_pregunta;
    $respuesta->save();
    if ($respuestas_usuario >= 7) {
        $suma_respuestas = Respuesta::where('id_user', $request->id_user)
            ->sum('respuesta');
        $nivel_id = $this->determinarNivel($suma_respuestas);

        Respuesta::where('id_user', $request->id_user)
            ->update(['id_nivel' => $nivel_id]);

        User::where('id', $request->id_user)
        ->update(['nivel_id' => $nivel_id]);
        return response()->json(['respuesta' => $respuesta, 'nivel_id' => $nivel_id], 201);
    }
    return response()->json(['respuesta' => $respuesta], 201);
}

    /**
     * @param $request
     * @return Response
     * 
     * Este método para determinar el nivel de usuario según las respuestas:
     * Nivel 1: Bajo, =<8
     * Nivel 2: Regular, >=9 - <= 11
     * Nivel 3: Moderado, >= 12 - <=14
     * Nivel 4: Alto, >=15
     */
    private function determinarNivel($suma_respuestas)
    {
    if ($suma_respuestas <= 8) {
        return 1; 
    } elseif ($suma_respuestas >= 9 && $suma_respuestas <= 11) {
        return 2; 
    } elseif ($suma_respuestas >= 12 && $suma_respuestas <= 14) {
        return 3; 
    } elseif ($suma_respuestas >=15){
        return 4;
    
    }
}
    
    /**
     * @param $request
     * @return Response
     * 
     * Este método muestra las respuetas del usuario.
     */
    public function show($id_user)
    {
        $respuesta = Respuesta::where('id_user',$id_user)->first();
        return response()->json($respuesta,200);
    }
}
