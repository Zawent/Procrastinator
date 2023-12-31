<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consejo;

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
        $consejos =new Consejo();
        $consejos->id_nivel = $request->id_nivel ;
        $consejos->consejo = $request->consejo ;
        $consejos->save();
        //Consejo::create($request->all());
        return response()->json($consejos,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consejos = Consejo::find($id);
        return response()->json($consejos,200);
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
        $consejos = Consejo::find($id);
        $consejos->update($request->all());
        return response()->json($consejos,200);
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
