<?php

namespace App\Http\Controllers;

use App\Events\NuevoMensajeChat;
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

    //
    public function getListarConversaciones(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $nIdContacto = $request->nIdContacto;
        $nIdAuthUser = Auth::id();

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Chat_getListarConversaciones(?,?)', [
            $nIdContacto,
            $nIdAuthUser
        ]);

        return $respuesta;
    }

    //
    function setRegistrarMensaje(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $from    = Auth::id();
        $to      = $request->nIdContacto;
        $message = utf8_encode($request->cMensaje);

        // echo "mensaje: $message";
        // dd();

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Chat_setRegistrarMensaje(?,?,?)', [
            $from,
            $to,
            $message
        ]);

        broadcast(new NuevoMensajeChat(
            $respuesta[0]
        ));

        return $respuesta;
    }
}
