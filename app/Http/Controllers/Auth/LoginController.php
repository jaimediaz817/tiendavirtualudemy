<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    // TODO: implementaciones propias:

    public function login(Request $request)
    {
        $cEmail      =   $request->cEmail;
        $cContrasena =   $request->cContrasena;

        $respuesta = Auth::attempt(['email' => $cEmail, 'password' => $cContrasena, 'state' => 'A' ]);

        if ($respuesta) {
            return response()->json([
                'authUser' => Auth::user(),
                'code'     => 200
            ]);
        } else {
            return response()->json([
                'code'     => 401,
                'pass'     => Hash::make("1234567890")
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'code'     => 204
        ]);
    }
}
