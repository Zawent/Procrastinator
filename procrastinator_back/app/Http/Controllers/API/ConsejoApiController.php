<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consejo;
use Carbon\Carbon;

class ConsejoApiController extends Controller
{
    /**
     * @param $request
     * @return Response
     * 
     * Este método obtiene todos los consejos.
     */
    public function index()
    {
        $consejos = Consejo::all();
        return response()->json($consejos,200);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método vavlida el id del nivel y crea un consejo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_nivel' => 'required|integer|between:1,4',
        ]);
        $consejo =new Consejo();
        $consejo->id_nivel = $request->id_nivel ;
        $consejo->consejo = $request->consejo ;
        $consejo->save();
        return response()->json($consejo,201);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método actua según el id del nivel, para que salga el consejo de ese nivel, 
     * tambien obtiene los consejos correspondientes al id de nivel dado.
     */
    public function show($id)
    {
        $consejos = Consejo::find($id);
        return response()->json($consejos,200,[],JSON_NUMERIC_CHECK);
    }
    public function consejosPorId($id_nivel)
    {
        $consejos = Consejo::where('id_nivel', $id_nivel)->get();
        return response()->json($consejos,200,[],JSON_NUMERIC_CHECK);
    }
    /**
     * @param $request
     * @return Response
     * 
     * Este método obtiene los consejos correspondientes al id de nivel del usuario y selecciona uno aleatoriamente.
     */

    public function consejoDiario($id_nivel)
    {
        $consejos = Consejo::where('id_nivel', $id_nivel)->inRandomOrder()->get();
        $consejoAleatorio = $consejos->random();
        return response()->json($consejoAleatorio,200,[],JSON_NUMERIC_CHECK);
    }
    /**
     * @param $request
     * @return Response
     * 
     * Este método actualiza la información de un consejo.
     */
    public function update(Request $request, $id)
    {
        $consejo = Consejo::find($id);
        $consejo->id_nivel = $request->id_nivel;
        $consejo->consejo = $request->consejo;
        $consejo->update();
        
        return response()->json($consejo,200,[],JSON_NUMERIC_CHECK);
    }

    /**
     * @param $request
     * @return Response
     * Este método elimina consejos por su id, pero debe haber al menos un consejo creado y no puede eliminar
     * todos los consejos con el mismo nivel de id.
     */

    public function destroy($id)
    {   
        $consejos = Consejo::find($id);
        $suma = Consejo::where('id_nivel', $consejos->id_nivel)->count();
        if ($suma == 1) {
            return response()->json(['message' => 'No se puede eliminar todos los consejos con el mismo nivel'], 400);
        }
        $consejos->delete();
        return response()->json($consejos,200);
    }

    /**
     * @param $request
     * @return Response
     * Este método cuenta la cantidad de consejos según el id de nivel.
     */

    public function contarConsejo($id_nivel){
        $suma = Consejo::where('id_nivel', $id_nivel)->count();
        return response()->json($suma);
    }
}
