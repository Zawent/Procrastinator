<?php

namespace App\Http\Controllers\Api;

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
        $request->validate([
            'id_nivel' => 'required|integer|between:1,4',
        ]);
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
        return response()->json($consejos,200);
    }
    
    public function consejosPorId($id_nivel)
    {
        $consejos = Consejo::where('id_nivel', $id_nivel)->get(); // sirve para que segun el id_nivel salga el consejo de ese nivel
        return response()->json($consejos,200);
    }


    public function consejoDiario($id_nivel)
    {
        $consejos = Consejo::where('id_nivel', $id_nivel)->inRandomOrder()->get(); // sirve para que segun el id_nivel salga el consejo de ese nivel
        $consejoAleatorio = $consejos->random();
        return response()->json($consejoAleatorio,200);
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
        
        return response()->json($consejo,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consejos = Consejo::find($id);
        $consejos->delete();
        return response()->json($consejos,200);
    }
}
