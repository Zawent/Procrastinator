<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Mail\Mailable;
use App\Http\Controllers\API\EmailVerificationController;
use App\Mail\VerifyEmail;
use App\Jobs\QueuedVerifyEmailJob;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller 
{

    /**
     * Registro de usuario y validaciones:
     * Recibe solo letras con espacios incluidos.
     * Sea una contraseña con minimo 8 caracteres.
     * Sea un correo valido con @.
     * Para que solo reciba letras con espacios incluidos.
     * Edad mínima de 12 años.
     * Fecha valida.
     * Ocupación valida.
     * Clave obligatorria.
     * Nombre valido.
     */
    public function signUp(Request $request)
    {       
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string||regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string|email|unique:users', 
            'password' => 'required|string|min:8',
            'fecha_nacimiento' => 'required|date|before_or_equal:' . now()->subYears(12)->format('Y-m-d') . '|date_format:Y-m-d',
            'ocupacion' => 'required|string||regex:/^[a-zA-Z\s]+$/'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.regex' => 'El nombre debe ser valido',
            'email.required' => 'El correo electronico es obligatorio.',
            'email.email' => 'El formato del correo electronico no es valido.',
            'email.unique' => 'Este correo electronico ya esta registrado.',
            'password.required' => 'La clave es obligatoria.',
            'password.min' => 'La clave debe tener al menos :min caracteres.',
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
        $user=User::create([
            'name' => $request->name,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'ocupacion' => $request->ocupacion,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_rol' => $request->id_rol,
            'email_verified_at' => null
        ]); 

        $now = date_create('now')->format('Y-m-d H:i:s');
        $timeIni = $now;

        $this->sendVerificationEmail($user);
        $tokenResult = $user->createToken('Personal Access Token');
        $now = date_create('now')->format('Y-m-d H:i:s');
        $timeFin = $now;
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'Inicio' => Carbon::parse($timeIni)->toDateTimeString(),
            'Fin' => Carbon::parse($timeFin)->toDateTimeString()
        ],200);
    }

    /**
     * Este método envía el código de verificación.
     */
    protected function sendVerificationEmail(User $user)
    {
        $user->sendEmailVerificationNotification();
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

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email not verified'
            ], 401);
        }

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
        $user=Auth::user();
        return response()->json($user);
    }
}