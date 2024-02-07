<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bloqueo;

class BloqueoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bloqueo = new Bloqueo();
        $bloqueo->tipo=$request->tipo;
        $bloqueo->hora_inicio=$request->hora_inicio;
        $bloqueo->duracion=$request->duracion;
        $bloqueo->estado=$request->estado;
        $bloqueo->id_app=$request->id_app;
        $bloqueo->save();
        return response()->json($bloqueo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

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
    public function update(Request $request, $id){

    $bloqueo = Bloqueo::find($id);
    $duracion = $request->input('duracion');

    if ($duracion > 0) {
        $bloqueo->estado = 'activo';
        return response()->json(['message' => 'Estado del bloqueo "Activo"']);

    } elseif ($duracion < 0) {
        $bloqueo->estado = 'inactivo';
        return response()->json(['message' => 'Estado del bloqueo "inactivo"']);

    } else {
        $bloqueo->estado = 'desbloqueado';
        return response()->json(['message' => 'Estado del bloqueo "desbloqueado"']);
    }

    $bloqueo->save();

    if ($bloqueo->estado=== 'activo'&& abs($duracion) >= 23){
        Comodin::create(['tiempo_generacion' => Carbon::now()]);
    }
    return response()->json(['message' => 'Estado del bloqueo actualizado']);
}


}
