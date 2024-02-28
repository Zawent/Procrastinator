<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bloqueo;
use App\Models\Comodin;
use App\Models\User;

class BloqueoApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bloqueo = Bloqueo::all();
        return response()->json($bloqueo, 200);
    }


    public function store(Request $request)
    { 
        $user = User::find($request->id_user); // busca al usuario por id

        if (!$user) {
            return response()->json(['mensaje' => 'El usuario especificado no existe'], 404);
        }

        $cantidadComodines = Comodin::where('id_user', $request->id_user)->count();
        if ($cantidadComodines >= 3) {
            return response()->json(['mensaje' => 'El usuario ya tiene el máximo número de comodines'], 400);
        }

        $duracionMaxima = 10 * 3600; // 10 horas en segundos
        $duracion = min($request->duracion, $duracionMaxima);
    
        // suma total de duraciones para todas las aplicaciones bloqueadas por el usuario
        $sumaDuraciones = $user->bloqueo()->sum('duracion')*3600;
        
    
        if ($sumaDuraciones >= 48 * 3600) {
            // mira si ya hay un comodín generado
            $comodinExistente = Comodin::where ('tiempo_generacion', '>=', now()->subHours(48))->exists();
    
            if (!$comodinExistente) {
                $comodin = new Comodin();
                $comodin->id_user = $request->id_user;
                $comodin->tiempo_generacion = now();
                $comodin->estado = $request->estado;
                $comodin->save();
            }
        }
    +
        $bloqueo = new Bloqueo();
        $bloqueo->hora_inicio = $request->hora_inicio;
        $bloqueo->duracion = $request->duracion;
        $bloqueo->estado = $request->estado;
        $bloqueo->id_app = $request->id_app;
        $bloqueo->id_user = $request->id_user;
        $bloqueo->save();
        
    
        return response()->json($bloqueo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bloqueo = Bloqueo::find($id);

        return response()->json([
            'Duracion del bloqueo' => $bloqueo->duracion,
            'Estado' => $bloqueo->estado
        ]);
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
        $bloqueo = Bloqueo::find($id);
        $duracion = $request->input('duracion');

        if ($duracion > 0) {
            $bloqueo->estado = 'activo';
            $bloqueo->save();
            return response()->json(['message' => 'Estado del bloqueo activo']);
        }else{
            $comodin = Comodin::where('id_user', $request->id_user)->where('estado', 'disponible')->first();
            
            if ($comodin) {
                $comodin->estado ='usado';
                $comodin->save();

                $bloqueo->estado ='desbloqueado';
                $bloqueo->save();
                
                return response()->json(['message'=> 'Haz desactivado tu bloqueo con un comodin']);
            }else{
                return response()->json(['message' => 'No tienes comodines disponibles para desbloquear']);
            
            }
            
        }
      
    }
}


