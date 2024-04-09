<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    /**
     * @param $request
     * @return Response
     * 
     * Este método envía un correo de verificación al registrar un usuario 
     * y valida si el usuario ya verificó su correo electrónico, si no se ha verificado,
     * envía una notificación por correo, si el usuario ya verificó su correo, se marca
     * como verificado.
     */

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Already Verified'
            ];
        }
        $request->user()->sendEmailVerificationNotification();

        return ['status' => 'verification-link-sent'];
    }
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Email already verified'
            ];
        }
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return [
            'message'=>'Email has been verified'
        ];
    }
}
