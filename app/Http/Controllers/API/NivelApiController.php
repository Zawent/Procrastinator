<?php

namespace App\Http\Controllers\Api;

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

}
