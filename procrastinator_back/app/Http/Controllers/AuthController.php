<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Registro de usuario
     */
    public function signUp(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string||regex:/^[a-zA-Z\s]+$/', //para que solo reciba letras con espacios incluidos
            'email' => 'required|string|email|unique:users', //sea un correo valido con @
            'password' => 'required|string|min:8',// sea una contraseña con minimo 8 caracteres
            'fecha_nacimiento' => 'required|date|before_or_equal:' . now()->subYears(12)->format('Y-m-d'),// la edad minima de creer cuenta es de 12 años
            'ocupacion' => 'required|string||regex:/^[a-zA-Z\s]+$/'// recibe solo letras con espacios incluidos
       
        ]);
        
        $user=User::create([
            'name' => $request->name,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'ocupacion' => $request->ocupacion,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_rol' => $request->id_rol
        ]); 

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ],200);

        /*return response()->json([
            'message' => 'Successfully created user!'
        ], 201);*/
    }
  
    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized----------'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }
  
    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
