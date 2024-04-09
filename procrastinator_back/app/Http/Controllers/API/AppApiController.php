<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App;

class AppApiController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     * 
     * Este método trae las aplicaciones.
     */

    public function index()
    {
        $apps = App::all();
        return response()->json($apps);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * Este método trae las aplicaciones según el id de usuario, y recupera el nombre de las aplicaciones para listarlas.
     */
     public function listarPorUser($id_user)
    {
        $app = App::where('id_user', $id_user)->get();
        return response()->json([
            'Nombre de la app' => $app->pluck('nombre'),
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * Este método verifica si la o las aplicaciones existen y las agrega a la base de datos.
     */

    public function store(Request $request)
    {
        $apps = explode(";", $request->nombre);
        if (count($apps)==1) {
            $app = App::where('nombre', $request->nombre)
                      ->where('id_user', $request->id_user)
                      ->first();
            if (!$app) {
                $app = new App();
            }
                $app->nombre = $request->nombre;
                $app->id_user = $request->id_user;
                $app->save();
                return response()->json($app, 201);
        } else {
            $total = count($apps);
            foreach($apps as $nombre) {
                $app = App::where('nombre', $nombre)
                      ->where('id_user', $request->id_user)
                      ->first();
                if (!$app) {
                    $app = new App();
                }
                    $app->nombre = $nombre;
                    $app->id_user = $request->id_user;
                    $app->save();
            }
            $respuesta=array();
            $respuesta["result"]="Add ".$total." Apps";
            return response()->json($respuesta, 201);
        }
    
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Este método muestra las aplicaciones asociadas al usuario.
     */
    public function show($id_user)
    {
        $app = App::where('id_user', $id_user)->get();
    return response()->json($app, 200);
    }

}
