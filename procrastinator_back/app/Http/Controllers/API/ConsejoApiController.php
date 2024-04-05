<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consejo;
use Carbon\Carbon;

class ConsejoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtener todos los consejos
        $consejos = Consejo::all();
        return response()->json($consejos,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //valida el id del nivel
        $request->validate([
            'id_nivel' => 'required|integer|between:1,4',
        ]);
        //crea un nuevo consejo
        $consejo =new Consejo();
        $consejo->id_nivel = $request->id_nivel ;
        $consejo->consejo = $request->consejo ;
        $consejo->save();
        //Consejo::create($request->all());
        return response()->json($consejo,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consejos = Consejo::find($id); // sirve para que segun el id_nivel salga el consejo de ese nivel
        return response()->json($consejos,200,[],JSON_NUMERIC_CHECK);
    }
    //obtener todos los consejos correspondientes al id de nivel dado
    public function consejosPorId($id_nivel)
    {
        $consejos = Consejo::where('id_nivel', $id_nivel)->get(); // sirve para que segun el id_nivel salga el consejo de ese nivel
        return response()->json($consejos,200,[],JSON_NUMERIC_CHECK);
    }


    public function consejoDiario($id_nivel)
    {
        //obtener todos los consejos correspondientes al id de nivel dado y seleccionar uno aleatoriamente
        $consejos = Consejo::where('id_nivel', $id_nivel)->inRandomOrder()->get(); // sirve para que segun el id_nivel salga el consejo de ese nivel
        $consejoAleatorio = $consejos->random();
        return response()->json($consejoAleatorio,200,[],JSON_NUMERIC_CHECK);
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
        $consejo = Consejo::find($id);
        $consejo->id_nivel = $request->id_nivel;
        $consejo->consejo = $request->consejo;
        $consejo->update();
        
        return response()->json($consejo,200,[],JSON_NUMERIC_CHECK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   //borrar un consejo por id
        $consejos = Consejo::find($id);
        $suma = Consejo::where('id_nivel', $consejos->id_nivel)->count();
        //si solo queda un consejo no se puede borrar
        if ($suma == 1) {
            return response()->json(['message' => 'No se puede eliminar todos los consejos con el mismo nivel'], 400);
        }
        // si quedan más de un consejo con el mismo id de nivel, eliminar el consejo
        $consejos->delete();
        return response()->json($consejos,200);
    }
    //cuenta y da la cantidad de consejos con id de nivel dado
    public function contarConsejo($id_nivel){
        $suma = Consejo::where('id_nivel', $id_nivel)->count();
        return response()->json($suma);
    }

}
