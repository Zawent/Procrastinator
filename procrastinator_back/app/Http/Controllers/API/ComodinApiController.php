<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comodin;
use App\Models\Bloqueo;
use App\Models\App; 

class ComodinApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comodin = Comodin::all();
        return response()->json($comodin,200);
    }   

     
    public function store(Request $request)
    {
    
        //  limite de 3 comodines
        $numComodines = Comodin::where('id_user', $request->id_user)->count();
        if ($numComodines >= 3) {
            return response()->json(['mensaje' => 'No puedes ganar más de 3 comodines'], 400);

        }
        $sumaTiemposBloqueo = Bloqueo::where('id_app', $app->id)->sum('duracion');
        //suma de los tiempos de bloqueo es igual o mayor a 48 horas
        if ($sumaTiemposBloqueo >= 48) {

            //  creacion del comodin
            $comodin = new Comodin();
            $tiempo_generacion = date('H:i:s');
            $comodin->id_app = $app->id; //formato que toca usar en vez de carbon
            $comodin->save();

            return response()->json(['comodin' => $comodin, 'tiempo_generacion' => $tiempo_generacion], 201);
     } else {
            return response()->json(['mensaje' => 'La suma de los tiempos de bloqueo debe ser igual o mayor a 48 horas para obtener un comodín.'], 400);
    }
    }
    

}