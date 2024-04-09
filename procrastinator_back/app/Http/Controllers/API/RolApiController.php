<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rol;

class RolApiController extends Controller
{
    /**
     * @param $request
     * @return Response
     * 
     * Este método obtiene todos los roles.
     */
    public function index()
    {
        $rols = Rol::all();
        return response()->json($rols, 200);
    }
    /**
     * @param $request
     * @return Response
     * 
     * Este método muestra los roles.
     */
    public function show($id)
    {
        $rol = Rol::find($id);
        return response()->json($rol, 201);
    }

}
