<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nivel;

class NivelApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nivel = Nivel::all();
        return response()->json($nivel,200);
    }

    public function show($id)
    {
        $nivel = Nivel::find($id);
        return response()->json($nivel,200);
    }

    public function store(Request $request){
        $nivel = new Nivel();
        $nivel->descripcion = $request->descripcion;
        $nivel->save();
        return response()->json($nivel,201);
    }

    public function update(Request $request, $id)
    {
        $nivel = Nivel::find($id);
        $nivel->descripcion = $request->descripcion;
        $nivel->update();
        
        return response()->json($nivel,200);
    }

    public function destroy($id)
    {
        $nivel = Nivel::find($id);
        $nivel->delete();
        return response()->json($nivel,200);
    }
}

