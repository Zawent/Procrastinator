<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bloqueo;
use App\Models\Comodin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BloqueoApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bloqueo = Bloqueo::all();
        return response()->json($bloqueo, 200);
    }


    public function store(Request $request)
    { 
        //$user = User::find($request->id_user); // busca al usuario por id
        $user = Auth::user();


        if (!$user) {
            return response()->json(['mensaje' => 'El usuario especificado no existe'], 404);
        }
        //--------------------------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------------------------
        $sumaBloqueos = Bloqueo::where('id_user', $user->id)->where('estado', 'activo')->count();//acuerdese de pasar el estado inactivo para probar
        $summaDuracion_nivel = $user->bloqueo()->sum(\DB::raw('TIME_TO_SEC(duracion)'))/3600;
        //--------------------------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------------------------
        
        $numComodinesActivos = Comodin::where('id_user', $user->id)->where('estado', 'activo')->count();
        if ($numComodinesActivos >= 3) {
            // Continuar con la creación de un nuevo bloqueo
            $bloqueo_comodin = 'no';
        } else {

            // suma total de duraciones para todas las aplicaciones bloqueadas por el usuario
            $sumaDuraciones = $user->bloqueo()->where('bloqueo_comodin', 'si')->sum(\DB::raw('TIME_TO_SEC(duracion)')) / 3600;
            
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

        $bloqueo = new Bloqueo();
        $bloqueo->hora_inicio = $request->hora_inicio;
        $bloqueo->duracion = $request->duracion;
        $bloqueo->estado = "activo";
        $bloqueo->id_app = $request->id_app;
        $bloqueo->id_user =  $user->id;
        $bloqueo->bloqueo_comodin = $bloqueo_comodin;
        $bloqueo->save();

        if ($summaDuracion_nivel >= 48){
            $nivel_id = $this->subirNivel($sumaBloqueos, $user->nivel_id);//aqui nombre a user para la tabla nivel_id porque decia que no estaba llamado
            $user->nivel_id = $nivel_id;
            $user->save();
        }

    return response()->json([$bloqueo, /*$summaDuracion_nivel*/], 201);
    }

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
    public function update(Request $request, $id)
    {
        $idUser = $request->id_user;
        $user = User::find($idUser);
        $bloqueo = Bloqueo::find($id);
        $duracion = $request->input('duracion');

        if ($duracion > 0) {
            $bloqueo->estado = 'activo';
            $bloqueo->save();
            return response()->json(['message' => 'Estado del bloqueo activo']);
        } else {
            $comodin = Comodin::where('id_user', $user->id)->where('estado', 'activo')->first();
            
            if ($comodin) {
                $comodin->estado ='usado';
                $comodin->save();

                $bloqueo->estado ='desbloqueado';
                $bloqueo->save();
                
                return response()->json(['message'=> 'Haz desactivado tu bloqueo con un comodin']);
            } else {
                return response()->json(['message' => 'No tienes comodines disponibles para desbloquear']);
            }
        }
    }
}
