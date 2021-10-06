<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{
    //
    public function getListarContactos(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $nIdAuthUser = Auth::id();

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Chat_getListarContactos(?)', [
            $nIdAuthUser
        ]);

        return $respuesta;
    }
}
