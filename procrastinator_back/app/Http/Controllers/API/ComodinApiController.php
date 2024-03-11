<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comodin;
use App\Models\Bloqueo;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

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
        //si el usuario existe
        $user = User::find($request->id_user);
        if (!$user) {
            return response()->json(['mensaje' => 'El usuario especificado no existe'], 404);
        }
        

        //  si el usuario ya ha ganado 3 comodines
        $numComodines = $user->comodines()->count();
        if ($numComodines >= 3) {
            return response()->json(['mensaje' => 'No puedes ganar más de 3 comodines'], 400);
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
        // comodines ganados por el usuario
        $comodines = Comodin::where('id_user', $request->id_user)->get();

        // muestra los comodines ganados en la respuesta
        return response()->json(['comodines' => $comodines], 200);

        $comodin = Comodin::find($id);

        if($comodin && $comodin->estado === 'activo') {
            $comodin->estado ='usado';
            $comodin->save();
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\Response
     */
    public function show($id_user)
    {
        // buscar los comodines asociados al ID de usuario
        $comodines = Comodin::where('id_user', $id_user)->get();

        //si se encontraron comodines para el usuario
        if ($comodines->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron comodines para el usuario especificado'], 404);
        }

        // retornar los comodines encontrados para el usuario
        return response()->json($comodines, 200);
    }
    
    public function cantidadComodines()
    {
        $user = Auth::user();
        $cantidadComodines = Comodin::where('id_user', $user->id)->where('estado', 'activo')->count();
        return response()->json($cantidadComodines, 200);
    }
}


