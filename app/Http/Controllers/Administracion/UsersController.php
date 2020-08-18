<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    public function getListarUsuarios(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $nIdUsuario =   $request->nIdUsuario;
        $cNombre    =   $request->cNombre;
        $cUsuario   =   $request->cUsuario;
        $cCorreo    =   $request->cCorreo;
        $cEstado    =   $request->cEstado;

        $nIdUsuario =   ($nIdUsuario  == NULL) ? ($nIdUsuario   =  0) : $nIdUsuario;
        $cNombre    =   ($cNombre     == NULL) ? ($cNombre   =  '') : $cNombre;
        $cUsuario   =   ($cUsuario    == NULL) ? ($cUsuario  =  '') : $cUsuario;
        $cCorreo    =   ($cCorreo     == NULL) ? ($cCorreo   =  '') : $cCorreo;
        $cEstado    =   ($cEstado     == NULL) ? ($cEstado   =  '') : $cEstado;

        // echo "nId usuario valor ::: $nIdUsuario";
        // exit(0);

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Usuario_getListarUsuarios (?, ?, ?, ?, ?)', [
            $nIdUsuario,
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
            $cSegundoNombre,
            $cApellido,                  
            $cUsuario,
            $cCorreo,      
            $cContrasena,
            $oFotografia
        ]);

        return $respuesta;
    }

    public function setEditarUsuario (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario     = $request->nIdUsuario;
        $cPrimerNombre  = $request->cPrimerNombre;
        $cSegundoNombre = $request->cSegundoNombre;
        $cApellido      = $request->cApellido;
        $cUsuario       = $request->cUsuario;
        $cCorreo        = $request->cCorreo;
        $cContrasena    = $request->cContrasena;

        if ($cContrasena != NULL) 
        {
            $cContrasena = Hash::make($cContrasena);
        }        

        $oFotografia    = $request->oFotografia;

        //echo "foto: $oFotografia";

        $nIdUsuario     = ($nIdUsuario      == NULL) ? ($nIdUsuario         =   '') : $nIdUsuario;
        $cPrimerNombre  = ($cPrimerNombre   == NULL) ? ($cPrimerNombre      =   '') : $cPrimerNombre;
        $cApellido      = ($cApellido       == NULL) ? ($cApellido          =   '') : $cApellido;
        $cSegundoNombre = ($cSegundoNombre  == NULL) ? ($cSegundoNombre     =   '') : $cSegundoNombre;
        $cUsuario       = ($cUsuario        == NULL) ? ($cUsuario           =   '') : $cUsuario;
        $cCorreo        = ($cCorreo         == NULL) ? ($cCorreo            =   '') : $cCorreo;
        $cContrasena    = ($cContrasena     == NULL) ? ($cContrasena        =   '') : $cContrasena;
        $oFotografia    = ($oFotografia     == NULL) ? ($oFotografia        = NULL) : $oFotografia;

        //echo "foto: $oFotografia , usuario: $cUsuario";
        //var_dump($request);
        //exit(0);

        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Usuario_setEditarUsuario (?, ?, ?, ?, ?, ?, ?, ?)', [
            $nIdUsuario,
            $cPrimerNombre,
            $cSegundoNombre,
            $cApellido,
            $cUsuario,
            $cCorreo,      
            $cContrasena,
            $oFotografia
        ]);

        return $respuesta;
    }

    public function setCambiarEstadoUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario   =   $request->nIdUsuario;
        $cEstado      =   $request->cEstado;

        $nIdUsuario   =   ($nIdUsuario  == NULL) ? ($nIdUsuario   =   0) :  $nIdUsuario;
        $cEstado      =   ($cEstado     == NULL) ? ($cEstado      =   0) :  $cEstado;

        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Usuario_setCambiarEstadoUsuario (?, ?)', [
            $nIdUsuario,
            $cEstado,
        ]);

        return $respuesta;        
    }
}
