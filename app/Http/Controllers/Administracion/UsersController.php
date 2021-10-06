<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $cContrasena    = Hash::make($request->cContrasena);
        $oFotografia    = $request->oFotografia;
        $nIdAuthUser    = Auth::id();

        //echo "foto: $oFotografia";

        $cPrimerNombre  = ($cPrimerNombre   == NULL) ? ($cPrimerNombre      =   '')     : $cPrimerNombre;
        $cApellido      = ($cApellido       == NULL) ? ($cApellido          =   '')     : $cApellido;
        $cSegundoNombre = ($cSegundoNombre  == NULL) ? ($cSegundoNombre     =   '')     : $cSegundoNombre;
        $cUsuario       = ($cUsuario        == NULL) ? ($cUsuario           =   '')     : $cUsuario;
        $cCorreo        = ($cCorreo         == NULL) ? ($cCorreo            =   '')     : $cCorreo;
        $cContrasena    = ($cContrasena     == NULL) ? ($cContrasena        =   '')     : $cContrasena;
        $oFotografia    = ($oFotografia     == NULL) ? ($oFotografia        =   NULL)   : $oFotografia;

        // echo "foto: $oFotografia";
        // exit(0);

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Usuario_setRegistrarUsuario (?, ?, ?, ?, ?, ?, ?, ?)', [
            $cPrimerNombre,
            $cSegundoNombre,
            $cApellido,                  
            $cUsuario,
            $cCorreo,      
            $cContrasena,
            $oFotografia,
            $nIdAuthUser
        ]);

        return $respuesta[0]->nIdUsuario;
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
        $nIdAuthUser    = Auth::id();

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
        $respuesta  =     DB::select('call sp_Usuario_setEditarUsuario (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $nIdUsuario,
            $cPrimerNombre,
            $cSegundoNombre,
            $cApellido,
            $cUsuario,
            $cCorreo,      
            $cContrasena,
            $oFotografia,
            $nIdAuthUser
        ]);

        return $respuesta;
    }

    public function setCambiarEstadoUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario   =   $request->nIdUsuario;
        $cEstado      =   $request->cEstado;
        $nIdAuthUser  = Auth::id();

        $nIdUsuario   =   ($nIdUsuario  == NULL) ? ($nIdUsuario   =   0) :  $nIdUsuario;
        $cEstado      =   ($cEstado     == NULL) ? ($cEstado      =   0) :  $cEstado;

        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Usuario_setCambiarEstadoUsuario (?, ?, ?)', [
            $nIdUsuario,
            $cEstado,
            $nIdAuthUser
        ]);

        return $respuesta;        
    }


    public function setEditarRolByUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario     = $request->nIdUsuario;
        $nIdRol         = $request->nIdRol;
        $nIdAuthUser    = Auth::id();

        $nIdUsuario     = ($nIdUsuario      == NULL) ? ($nIdUsuario         =   '') : $nIdUsuario;
        $nIdRol         = ($nIdRol          == NULL) ? ($nIdRol             =   '') : $nIdRol;    
        
        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Usuario_setEditarRolByUsuario (?, ?)', [
            $nIdUsuario,
            $nIdRol
        ]);

        return $respuesta;        
    }

    public function getRolByUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario     = $request->nIdUsuario;

        $nIdUsuario     = ($nIdUsuario      == NULL) ? ($nIdUsuario         =   '') : $nIdUsuario;
        
        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Usuario_getRolByUsuario (?)', [
            $nIdUsuario
        ]);

        return $respuesta;
    }

    public function getListarPermisosByRolAsignado (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario     = $request->nIdUsuario;
        $nIdUsuario     = ($nIdUsuario      == NULL) ? ($nIdUsuario         =   '') : $nIdUsuario;
        

        /**
         * Obtener los permisos que tiene ese rol  por usuario
         */
        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Usuario_getListarPermisosByRolAsignado (?)', [
            $nIdUsuario
        ]);

        return $respuesta;
    }

    // TODO: here:  05-09-2020
    public function getListarPermisosByUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario  = $request->nIdUsuario;
        //$nIdUsuario  = ($nIdUsuario  == NULL) ? ($nIdUsuario   =   0) : $nIdUsuario;
        
        if (!$nIdUsuario  || $nIdUsuario == NULL || $nIdUsuario == "") {
            $nIdUsuario =  Auth::id();
        }
        /**
         * Obtener los permisos que tiene ese rol  por usuario
         */
        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Usuario_getListarPermisosByUsuario (?)', [
            $nIdUsuario
        ]);

        return $respuesta;        
    }

    public function setRegistrarPermisosByUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario  = $request->nIdUsuario;
        $nIdUsuario  = ($nIdUsuario  == NULL) ? ($nIdUsuario   =   0) : $nIdUsuario;

        //  Transacciones
        try 
        {
            DB::beginTransaction();

            // Mecanismo procedimiento almacenado
            $respuesta  =   DB::select('call sp_Usuario_setEliminarPermisosByUsuario (?)', [
                $nIdUsuario
            ]);

            $listPermisos       =       $request->listPermisosFilter;
            $listPermisosSize   =       sizeof($listPermisos);

            if ($listPermisosSize > 0) 
            {            
                foreach ($listPermisos as $key => $value)
                {
                    if ($value['checked'] == true) {
                        // Mecanismo procedimiento almacenado
                        $respuesta  =   DB::select('call sp_Usuario_setRegistrarPermisosByUsuario (?, ?)', [
                            $nIdUsuario,
                            $value['id']
                        ]);
                    }
                }
            }
            
            DB::commit();
            $respuesta['success'] = true;
            return json_encode($respuesta);
        }
        catch (Exception $e)
        {
            // captura algún error ocurrido dentro del bloque "try"
            DB::rollBack();
            $respuesta['success'] = false;
            $respuesta['error'] = $e;
            return json_encode($respuesta);
        }
    }

    /**
     * @param {Request} peticion
     * 
     * Funcion que permite obtener los permisos según el rol 
     * y el usuario autenticado
     */
    public function getListarRolPermisosByUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdUsuario  = $request->nIdUsuario;

        if (!$nIdUsuario  || $nIdUsuario == NULL || $nIdUsuario == "") {
            $nIdUsuario =  Auth::id();
        }

        $nIdUsuario  = ($nIdUsuario  == NULL) ? ($nIdUsuario   =   0) : $nIdUsuario;
        
        /**
         * Obtener los permisos que tiene ese rol  por usuario
         */
        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Usuario_getListarRolPermisosByUsuario (?)', [
            $nIdUsuario
        ]);

        return $respuesta;             
    }
}
