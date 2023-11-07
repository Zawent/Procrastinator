<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Respuesta;

class EncuestaApiController extends Controller
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
        $respuesta =new Respuesta();
        $respuesta->id_usuario = $request->id_usuario ;
        $respuesta->pregunta = $request->pregunta ;
        $respuesta->respuesta = $request->respuesta ;
        $respuesta->id_nivel = $request->id_nivel ;
        $respuesta->save();
        //Consejo::create($request->all());
        return response()->json($respuesta,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
