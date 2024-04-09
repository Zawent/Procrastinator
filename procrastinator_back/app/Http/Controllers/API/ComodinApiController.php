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
     * @param $request
     * @return Response
     * 
     * Este método envia un mensaje de error si un usuario tiene más de 3 comodines.
     */
    public function store(Request $request)
    {
        $user = User::find($request->id_user);
        if (!$user) {
            return response()->json(['mensaje' => 'El usuario especificado no existe'], 404);
        }
        $numComodines = $user->comodines()->count();
        if ($numComodines >= 3) {
            return response()->json(['mensaje' => 'No puedes ganar más de 3 comodines'], 400);
        }
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método actualiza los comodines ganados por un usuario y cambia el estado de un comodín
     * activo a usado.
     */
    public function update(Request $request, $id)
    {
        $comodines = Comodin::where('id_user', $request->id_user)->get();
        return response()->json(['comodines' => $comodines], 200);
        $comodin = Comodin::find($id);
        if($comodin && $comodin->estado === 'activo') {
            $comodin->estado ='usado';
            $comodin->save();
        }
    }
    
    /**
     * @param $request
     * @return Response
     * 
     * Este método muestra los comodines asociados a un usuario,
     */
    public function show($id_user)
    {
        $comodines = Comodin::where('id_user', $id_user)->get();
        if ($comodines->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron comodines para el usuario especificado'], 404);
        }
        return response()->json($comodines, 200);
    }
    
    /**
     * @param $request
     * @return Response
     * 
     * Este método cuenta los comodines de estado activo asociados al usuario.
     */
    public function cantidadComodines()
    {
        $user = Auth::user();
        $cantidadComodines = Comodin::where('id_user', $user->id)->where('estado', 'activo')->count();
        return response()->json($cantidadComodines, 200);
    }
}
    


