<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nivel;

class NivelApiController extends Controller
{
    /**
     * @param $request
     * @return Response
     * 
     * Este método obtiene todos los niveles.
     */

    public function index()
    {
        $nivel = Nivel::all();
        return response()->json($nivel,200);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método muestra los niveles.
     */
    public function show($id)
    {
        $nivel = Nivel::find($id);
        return response()->json($nivel,200);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método crea un nivel.
     */
    public function store(Request $request){
        $nivel = new Nivel();
        $nivel->descripcion = $request->descripcion;
        $nivel->save();
        return response()->json($nivel,201);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método actualiza los niveles
     */
    public function update(Request $request, $id)
    {
        $nivel = Nivel::find($id);
        $nivel->descripcion = $request->descripcion;
        $nivel->update();
        
        return response()->json($nivel,200);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método elimina los niveles.
     */
    public function destroy($id)
    {
        $nivel = Nivel::find($id);
        $nivel->delete();
        return response()->json($nivel,200);
    }
}

