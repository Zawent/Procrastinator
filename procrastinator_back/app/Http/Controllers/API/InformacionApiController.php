<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Informacion;

class InformacionApiController extends Controller


{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informacion = Informacion::all();
        return response()->json($informacion, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $informacion = new Informacion();
        $informacion->id_user=$request->id_user;
        $informacion->id_app=$request->id_app;
        $informacion->id=$request->id;
        $informacion->id_bloqueo=$request->id_bloqueo;
        $informacion->id_nivel=$request->id_nivel;
        return response()->json($informacion, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $informacion = Informacion::find($id);
        return response()->json($informacion, 201);
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
        $informacion = Informacion::find($id);
        $informacion->id_user=$request->id_user;
        $informacion->id_app=$request->id_app;
        $informacion->id=$request->id;
        $informacion->id_bloqueo=$request->id_bloqueo;
        $informacion->id_nivel=$request->id_nivel;
        $informacion->update();
        return response()->json($informacion, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $informacion = Informacion::find($id);
        $informacion->delete();
        return response()->json(null, 204);
    }
}
