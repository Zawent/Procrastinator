<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App;

class AppApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //trae las aplicaciones de la base de datos
        $apps = App::all();
        return response()->json($apps);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     //recupera las aplicaciones asociadas al usuario por su id
     public function listarPorUser($id_user)
    {
        $app = App::where('id_user', $id_user)->get();
        //recupera las aplicaciones con sus nombres
        return response()->json([
            'Nombre de la app' => $app->pluck('nombre'),
        ]);
    }

    public function store(Request $request)
    {
        //divide el nombre de la aplicación por ;
        $apps = explode(";", $request->nombre);

        //si solo se proporciona una aplicacion verifica que exista en la base de datos
        if (count($apps)==1) {
            $app = App::where('nombre', $request->nombre)
                      ->where('id_user', $request->id_user)
                      ->first();
            //si la aplicacion no existe crea una nueva y establece el nombre y id de usuario de la app
            if (!$app) {
                $app = new App();
            }
                $app->nombre = $request->nombre;
                $app->id_user = $request->id_user;
                $app->save();
                return response()->json($app, 201);
        } else {
            //si se proporcionan más aplicaciones verifica que existan en la base de datos
            $total = count($apps);
            foreach($apps as $nombre) {
                $app = App::where('nombre', $nombre)
                      ->where('id_user', $request->id_user)
                      ->first();
                //si no existe crea una nueva app
                if (!$app) {
                    $app = new App();
                }
                //establece el nombre y id de usuario de la aplicacion
                    $app->nombre = $nombre;
                    $app->id_user = $request->id_user;
                    $app->save();
            }
            //retorna un mensaje indicando cuántas aplicaciones se agregaron
            $respuesta=array();
            $respuesta["result"]="Add ".$total." Apps";
            return response()->json($respuesta, 201);
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_user)
    {
        //recupera las aplicaciones asociadas con el id de usuario
        $app = App::where('id_user', $id_user)->get();
        //retorna la aplicaciones encontradas
    return response()->json($app, 200);
    }

}
