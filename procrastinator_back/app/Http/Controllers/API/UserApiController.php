<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name=$request->name;
        $user->fecha_nacimiento=$request->fecha_nacimiento;
        $user->ocupacion=$request->ocupacion;
        $user->email=$request->email;
        $hashedPassword = Hash::make($request->password);
        $user->password = $hashedPassword; 
        $user->id_rol=$request->id_rol;
        $user->save();
        return response()->json($user, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user, 201);
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
        $user = User::find($id);
        $user->name=$request->name;
        $user->fecha_nacimiento=$request->fecha_nacimiento;
        $user->ocupacion=$request->ocupacion;
        $user->email=$request->email;
        if (isset($request->password) && strlen($request->password)>=8) {
            $hashedPassword = Hash::make($request->password);
            $user->password = $hashedPassword;
        }
        $user->id_rol=$request->id_rol;
        $user->update();
        return response()->json($user, 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(null, 204);
    }

    public function verificarNivel($id){
        $user = User::find($id);
        $nivel_id = $user->nivel_id;

        if ($nivel_id == null){
            $nivel_id = 0;
            return response()->json($nivel_id, 200);
        }else{
            return $nivel_id;
        }

}
}
