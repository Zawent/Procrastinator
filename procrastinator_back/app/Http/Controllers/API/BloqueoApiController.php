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
        $user = User::find($request->id_user); // Encuentra al usuario por su ID

        if (!$user) {
            return response()->json(['mensaje' => 'El usuario especificado no existe'], 404);
        }
    
        // Calcula la suma total de duraciones para todas las aplicaciones bloqueadas por el usuario
        $sumaDuraciones = $user->bloqueo()->sum('duracion');
    
        if ($sumaDuraciones >= 48 * 3600) {
            // Verifica si ya hay un comodín generado
            $comodinExistente = Comodin::where('tiempo_generacion', '>=', now()->subHours(24))->exists();
    
            // Si no hay comodín generado en las últimas 24 horas, crea uno nuevo
            if (!$comodinExistente) {
                $comodin = new Comodin();
                $comodin->id_user = $request->id_user;
                $comodin->tiempo_generacion = now();
                $comodin->save();
            }
        }
    
        $bloqueo = new Bloqueo();
        $bloqueo->tipo = $request->tipo;
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
            'Tipo de bloqueo' => $bloqueo->tipo,
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
            return response()->json(['message' => 'Estado del bloqueo "Activo"']);
      
        $bloqueo->save();
        return response()->json(['message' => 'Estado del bloqueo actualizado']);
    }
}
}