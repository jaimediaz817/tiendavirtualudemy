<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
    //
    public function getListarPermisos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdPermiso =   $request->nIdPermiso;
        $cNombre    =   $request->cNombre;
        $cSlug      =   $request->cSlug;
        
        $nIdPermiso =   ($nIdPermiso  == NULL) ? ($nIdPermiso   =   0) : $nIdPermiso;
        $cNombre    =   ($cNombre     == NULL) ? ($cNombre      =  '') : $cNombre;
        $cSlug      =   ($cSlug       == NULL) ? ($cSlug        =  '') : $cSlug;        

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Permiso_getListarPermisos (?, ?, ?)', [
            $nIdPermiso,
            $cNombre,
            $cSlug    
        ]);

        return $respuesta;          
    }

    public function setRegistrarPermiso(Request $request )
    {
        if (!$request->ajax()) return redirect('/');

        $cNombre    =   $request->cNombre;
        $cSlug      =   $request->cSlug;
        
        $cNombre    =   ($cNombre     == NULL) ? ($cNombre      =  '') : $cNombre;
        $cSlug      =   ($cSlug       == NULL) ? ($cSlug        =  '') : $cSlug;        

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Permiso_setRegistrarPermiso (?, ?)', [
            $cNombre,
            $cSlug    
        ]);        
    }

    public function setEditarPermiso(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdPermiso =   $request->nIdPermiso;
        $cNombre    =   $request->cNombre;
        $cSlug      =   $request->cSlug;
        
        $nIdPermiso =   ($nIdPermiso  == NULL) ? ($nIdPermiso   =   0) : $nIdPermiso;
        $cNombre    =   ($cNombre     == NULL) ? ($cNombre      =  '') : $cNombre;
        $cSlug      =   ($cSlug       == NULL) ? ($cSlug        =  '') : $cSlug;        

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Permiso_setEditarPermiso (?, ?, ?)', [
            $nIdPermiso,
            $cNombre,
            $cSlug    
        ]);                
    }
}
