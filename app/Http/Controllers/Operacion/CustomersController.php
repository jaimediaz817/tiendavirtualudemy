<?php

namespace App\Http\Controllers\Operacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    //
    public function getListarClientes(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $nIdCliente     =   $request->nIdCliente;
        $cDocumento     =   $request->cDocumento;
        $cNombre        =   $request->cNombre;

        $nIdCliente     =   ($nIdCliente   == NULL) ? ($nIdCliente  =   0) : $nIdCliente;
        $cNombre        =   ($cNombre      == NULL) ? ($cNombre     =  '') : $cNombre;
        $cDocumento     =   ($cDocumento   == NULL) ? ($cDocumento  =  '') : $cDocumento;

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Cliente_getListarClientes (?, ?, ?)', [
            $nIdCliente,
            $cNombre,
            $cDocumento
        ]);

        return json_encode($respuesta);
    }

    public function setRegistrarCliente(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $cDocumento     =   $request->cDocumento;
        $cNombre        =   $request->cNombre;
        $cApellido      =   $request->cApellido;
        $cCorreo        =   $request->cCorreo;
        $cTelefono      =   $request->cTelefono;
        $nIdAuthUser    =   Auth::id();

        $cNombre        =   ($cNombre      == NULL) ? ($cNombre     =  '') : $cNombre;
        $cDocumento     =   ($cDocumento   == NULL) ? ($cDocumento  =  '') : $cDocumento;
        $cApellido      =   ($cApellido    == NULL) ? ($cApellido   =  '') : $cApellido;
        $cCorreo        =   ($cCorreo      == NULL) ? ($cCorreo     =  '') : $cCorreo;
        $cTelefono      =   ($cTelefono    == NULL) ? ($cTelefono   =  '') : $cTelefono;


        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Cliente_setRegistrarCliente (?, ?, ?, ?, ?, ?)', [
            $cDocumento,
            $cNombre,
            $cApellido,
            $cCorreo,
            $cTelefono,
            $nIdAuthUser
        ]);

        return $respuesta;
    }

    public function setEditarCliente(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $nIdCliente    =   $request->nIdCliente;
        $nIdCliente    =   ($nIdCliente == NULL) ? ($nIdCliente = '') : $nIdCliente;

        $cDocumento     =   $request->cDocumento;
        $cNombre        =   $request->cNombre;
        $cApellido      =   $request->cApellido;
        $cEmail         =   $request->cEmail;
        $cTelefono      =   $request->cTelefono;
        $nIdAuthUser    =   Auth::id();

        $cNombre        =   ($cNombre      == NULL) ? ($cNombre     =  '') : $cNombre;
        $cDocumento     =   ($cDocumento   == NULL) ? ($cDocumento  =  '') : $cDocumento;
        $cApellido      =   ($cApellido    == NULL) ? ($cApellido   =  '') : $cApellido;
        $cEmail         =   ($cEmail       == NULL) ? ($cEmail      =  '') : $cEmail;
        $cTelefono      =   ($cTelefono    == NULL) ? ($cTelefono   =  '') : $cTelefono;


        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Cliente_setEditarCliente (?, ?, ?, ?, ?, ?, ?)', [
            $nIdCliente,
            $cDocumento,
            $cNombre,
            $cApellido,
            $cEmail,
            $cTelefono,
            $nIdAuthUser
        ]);

        return $respuesta;
    }
}
