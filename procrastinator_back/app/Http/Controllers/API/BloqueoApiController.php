<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bloqueo;
use App\Models\Comodin;
use App\Models\User;
use App\Models\App;
use Illuminate\Support\Facades\Auth;

class BloqueoApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //muestra todos los registros de bloqueo
    public function index()
    {
        $bloqueo = Bloqueo::all();
        return response()->json($bloqueo, 200);
    }


    public function store(Request $request)
    { 
        //verifica que el usuario esta autenticado
        $user = Auth::user();

        if (!$user) {
            return response()->json(['mensaje' => 'El usuario especificado no existe'], 404);
        }
      
        //crea un bloqueo
        $bloqueo = new Bloqueo();
        $bloqueo->hora_inicio = $request->hora_inicio;
        $bloqueo->duracion = $request->duracion;
        $bloqueo->estado = "activo";
        $bloqueo->id_app = $request->id_app;
        $bloqueo->bloqueo_comodin = "si";
        $bloqueo->id_user =  $user->id;
        $bloqueo->save();        
        return response()->json($bloqueo, 201);
    }



    //metodo para subir el nivel del usuario segun la cantidad de bloqueos
    public function subirNivel($sumaBloqueos, $nivel_id){

        if ($sumaBloqueos>=40 && $nivel_id == 4){
            return 3;
        }elseif ($sumaBloqueos>=80 && $nivel_id == 3) {
            return 2;
        }elseif ($sumaBloqueos>=120 && $nivel_id == 2){
            return 1;
        } else {
            return $nivel_id;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bloqueo = Bloqueo::find($id);

        return response()->json([
            'Duracion del bloqueo' => $bloqueo->duracion,
            'Estado' => $bloqueo->estado
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //marca cuando el bloqueo esta activo
    public function update(Request $request, $id)
    {
        $idUser = $request->id_user;
        $user = User::find($idUser);
        $bloqueo = Bloqueo::find($id);
        $duracion = $request->input('duracion');
        $duracionActual = $bloqueo->duracion;

        if ($duracion > 0) {
            $bloqueo->estado = 'activo';
            $bloqueo->save();
            return response()->json(['message' => 'Estado del bloqueo activo']);
        } else {
            if ($duracionActual <= 0 && $bloqueo->estado == 'activo') {
            $comodin = Comodin::where('id_user', $user->id)->where('estado', 'activo')->first();
            //si hay un comodin activo, usarlo para desbloquear un bloqueo
            if ($comodin) {
                $comodin->estado ='usado';
                $comodin->save();

                $bloqueo->estado ='desbloqueado';
                $bloqueo->save();
                
                return response()->json(['message'=> 'Haz desactivado tu bloqueo con un comodin']);
            } else {
                return null;
            }
        }
 }
        
    }
    //marcar el bloqueo como desbloqueado

    public function marcarDesbloqueado(Request $request)
    {
        $user = User::find($request->id_user);
        $bloqueo = Bloqueo::where('estado', 'activo')->where('id_user', $user->id)->first();
        
        if ($bloqueo) {
            $bloqueo->estado = 'desbloqueado';
            $bloqueo->save();
 //calcula la suma de bloqueos y duracion 
        //--------------------------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------------------------
        $sumaBloqueos = Bloqueo::where('id_user', $user->id)->where('estado', 'bloqueado')->count();//acuerdese de pasar el estado inactivo para probar
        $summaDuracion_nivel = $user->bloqueo()->sum(\DB::raw('TIME_TO_SEC(duracion)'))/3600;
        //--------------------------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------------------------

        //verifica si hay 3 comodines activos
        $numComodinesActivos = Comodin::where('id_user', $user->id)->where('estado', 'activo')->count();
        if ($numComodinesActivos >= 3) {
            $bloqueo_comodin = 'no';
        } else {
            $sumaDuraciones = $user->bloqueo()->where('bloqueo_comodin', 'si')->sum(\DB::raw('TIME_TO_SEC(duracion)')) / 3600;
            //crea un comodin
            if ($sumaDuraciones >= 48) {
                $comodin = new Comodin();
                $comodin->id_user = $user->id;
                $comodin->tiempo_generacion = now();
                $comodin->estado = "activo";
                $comodin->save();
                $user->bloqueo()->where('bloqueo_comodin', 'si')->update(['bloqueo_comodin' => 'no']);
            }
            $bloqueo_comodin = $sumaDuraciones >= 48 ? 'no' : 'si';
        }

        //subir nivel de usuario
        if ($summaDuracion_nivel >= 48){
            $nivel_id = $this->subirNivel($sumaBloqueos, $user->nivel_id);//aqui nombre a user para la tabla nivel_id porque decia que no estaba llamado
            $user->nivel_id = $nivel_id;
            $user->save();
        }

        
        if ($bloqueo_comodin == 'si') {
            $sumaDuraciones = $user->bloqueo()->where('bloqueo_comodin', 'si')->sum(\DB::raw('TIME_TO_SEC(duracion)')) / 3600;
            if ($sumaDuraciones < 48) {
                $bloqueo->bloqueo_comodin = 'no';
                $bloqueo->save();
            }
        }

            return response()->json(['message' => 'Bloqueo marcado como desbloqueado'], 200);
        } else {
            return response()->json(['message' => 'No se encontró un bloqueo activo para el usuario'], 404);
        }

         
    }
    //metodo para obtener el bloqueo acivo de un usuario
    public function getBloqueo ()
    {
        $user = Auth::user();
        $bloqueo = Bloqueo::where('estado', 'activo')->where('id_user', $user->id)->first();
        return response()->json($bloqueo, 200);
    }
    //metodo para listar las aplicaciones mas usadas
    public function listarTopApps(){
        $user = Auth::user();

        if (!$user) {
            return response()->json(['mensaje' => 'El usuario especificado no existe'], 404);
        }else{
            $resultados= [];
            $bloqueosUser = Bloqueo::where('id_user', $user->id)->get();
            $contadorApps = $bloqueosUser->groupBy('id_app')->map->count();

            $topContadores = $contadorApps->sortByDesc(function ($contador) {
                return $contador;
            });

            $top4Contadores = $topContadores->take(3);
    
            foreach ($top4Contadores as $id_app => $contador){
                $app = App::find($id_app);
                $nombre = $app->nombre;
                $datos = array();
                $datos['nombre']=$app->nombre;
                $datos['contador']=$contador;
                $resultados[] = $datos;
            }
            return response()->json(["resultados" => $resultados], 200, [], JSON_NUMERIC_CHECK);
        }
    }
}