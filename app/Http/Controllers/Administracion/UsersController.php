<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    //
    public function getListarUsuarios(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $cNombre    =   $request->cNombre;
        $cUsuario   =   $request->cUsuario;
        $cCorreo    =   $request->cCorreo;
        $cEstado    =   $request->cEstado;

        $cNombre    =   ($cNombre  == NULL) ? ($cNombre   =  '') : $cNombre;
        $cUsuario   =   ($cUsuario == NULL) ? ($cUsuario  =  '') : $cUsuario;
        $cCorreo    =   ($cCorreo  == NULL) ? ($cCorreo   =  '') : $cCorreo;
        $cEstado    =   ($cEstado  == NULL) ? ($cEstado   =  '') : $cEstado;

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Usuario_getListarUsuarios (?, ?, ?, ?)', [
            $cNombre,
            $cUsuario,
            $cCorreo,
            $cEstado
        ]);
        return $respuesta;
    }

    public function setRegistrarUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cPrimerNombre  = $request->cPrimerNombre;
        $cSegundoNombre = $request->cSegundoNombre;
        $cApellido      = $request->cApellido;
        $cUsuario       = $request->cUsuario;
        $cCorreo        = $request->cCorreo;
        $cContrasena    = $request->cContrasena;
        $oFotografia    = $request->oFotografia;

        //echo "foto: $oFotografia";

        $cPrimerNombre  = ($cPrimerNombre   == NULL) ? ($cPrimerNombre   =   '') : $cPrimerNombre;
        $cApellido      = ($cApellido       == NULL) ? ($cApellido   =   '') : $cApellido;
        $cSegundoNombre = ($cSegundoNombre  == NULL) ? ($cSegundoNombre   =   '') : $cSegundoNombre;
        $cUsuario       = ($cUsuario        == NULL) ? ($cUsuario   =   '') : $cUsuario;
        $cCorreo        = ($cCorreo         == NULL) ? ($cCorreo   =   '') : $cCorreo;
        $cContrasena    = ($cContrasena     == NULL) ? ($cContrasena   =   '') : $cContrasena;
        $oFotografia    = ($oFotografia     == NULL) ? ($oFotografia   =   NULL) : $oFotografia;

        // echo "foto: $oFotografia";
        // exit(0);

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Usuario_setRegistrarUsuario (?, ?, ?, ?, ?, ?, ?)', [
            $cPrimerNombre,
            $cApellido,      
            $cSegundoNombre,
            $cUsuario,
            $cCorreo,      
            $cContrasena,
            $oFotografia
        ]);

        return $respuesta;        

    }
}
