<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    //metodo para enviar el correo de verificacion
    public function sendVerificationEmail(Request $request)
    {
        //verifica si el usuario ya ahe verificado su correo electronico
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Already Verified'
            ];
        }
        // Si no está verificado, enviar la notificación de verificación por correo electrónico
        $request->user()->sendEmailVerificationNotification();

        return ['status' => 'verification-link-sent'];
    }
    //metodo para verificar el correo electronico
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Email already verified'
            ];
        }
//marcar el correo del usuario como verificado
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return [
            'message'=>'Email has been verified'
        ];
    }
}
