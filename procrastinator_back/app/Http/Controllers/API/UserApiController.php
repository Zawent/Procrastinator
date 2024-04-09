<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserApiController extends Controller
{
    /**
     * @param $request
     * @return Response
     * 
     * Este método obtiene todos los usuarios.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método crea los usuarios.
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
     * @param $request
     * @return Response
     * 
     * Este método muestra los usuarios.
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user, 201);
    }

    /**
     * @param $request
     * @return Response
     * 
     * Este método actualiza la información del usuario con validaciones.
     */
    public function update(Request $request, $id)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string||regex:/^[a-zA-Z\s]+$/',
            'fecha_nacimiento' => 'required|date|before_or_equal:' . now()->subYears(12)->format('Y-m-d') . '|date_format:Y-m-d',
            'ocupacion' => 'required|string||regex:/^[a-zA-Z\s]+$/'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.regex' => 'El nombre debe ser valido',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha valida.',
            'fecha_nacimiento.before_or_equal' => 'Debes tener mas edad (minimo 12).',
            'fecha_nacimiento.date_format' => 'El formato de fecha de nacimiento no es valido.',
            'ocupacion.required' => 'La ocupacion es obligatoria.',
            'ocupacion.regex' => 'La ocupacion debe ser valida'
       
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('name')) {
                return response()->json(['error' => $errors->first('name')], 400);
            }elseif ($errors->has('email')) {
                return response()->json(['error' => $errors->first('email')], 400);
            }elseif ($errors->has('password')) {
                return response()->json(['error' => $errors->first('password')], 400);
            }elseif ($errors->has('fecha_nacimiento')) {
                return response()->json(['error' => $errors->first('fecha_nacimiento')], 400);
            }elseif ($errors->has('ocupacion')) {
                return response()->json(['error' => $errors->first('ocupacion')], 400);
            }
        }


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
     * @param $request
     * @return Response
     * 
     * Este método elimina usuarios.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(null, 204);
    }
}

