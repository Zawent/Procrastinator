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
        $bloqueo->id();
        $bloqueo->string('tipo');
        $bloqueo->time('hora_inicial');
        $bloqueo->time('duracion');
        $bloqueo->string('estado');
        $bloqueo->foreignId('id_app');
        $bloqueo->foreign('id_app')->references('id')->on('apps');
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


}


}
