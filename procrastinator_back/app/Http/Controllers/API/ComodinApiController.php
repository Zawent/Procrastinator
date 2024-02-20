<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comodin;
use App\Models\Bloqueo;
use App\Models\User; 

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
        return response()->json(['comodines' => $comodines], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Verificar si el usuario existe
        $user = User::find($request->id_user);
        if (!$user) {
            return response()->json(['mensaje' => 'El usuario especificado no existe'], 404);
        }

        // Verificar si el usuario ya ha ganado 3 comodines
        $numComodines = $user->comodines()->count();
        if ($numComodines >= 3) {
            return response()->json(['mensaje' => 'No puedes ganar más de 3 comodines'], 400);
        }

        // Verificar si la suma de los tiempos de bloqueo es igual o mayor a 48 horas
        $sumaTiemposBloqueo = $user->bloqueos()->sum('duracion');
        if ($sumaTiemposBloqueo >= 48 * 3600) {
            // Crear un nuevo comodín
            $comodin = new Comodin();
            $comodin->id_app = $request->id_app; 
            $comodin->id_user = $request->id_user;
            $comodin->estado = 'activo';
            $comodin->save();

            return response()->json(['comodin' => $comodin], 201);
        } else {
            return response()->json(['mensaje' => 'La suma de los tiempos de bloqueo debe ser igual o mayor a 48 horas para obtener un comodín.'], 400);
        }
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
        // Encuentra los comodines ganados por el usuario
        $comodines = Comodin::where('id_user', $request->id_user)->get();

        // Muestra los comodines ganados en la respuesta
        return response()->json(['comodines' => $comodines], 200);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\Response
     */
    public function show($id_user)
    {
        // Buscar los comodines asociados al ID de usuario
        $comodines = Comodin::where('id_user', $id_user)->get();

        // Verificar si se encontraron comodines para el usuario
        if ($comodines->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron comodines para el usuario especificado'], 404);
        }

        // Retornar los comodines encontrados para el usuario
        return response()->json(['comodines' => $comodines], 200);
    }
}
