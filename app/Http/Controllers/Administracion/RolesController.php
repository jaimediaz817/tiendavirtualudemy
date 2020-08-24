<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    //
    public function getListarRoles (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdRol     =   $request->nIdRol;
        $cNombre    =   $request->cNombre;
        $cSlug      =   $request->cSlug;
        
        $nIdRol     =   ($nIdRol      == NULL) ? ($nIdRol    =   0) : $nIdRol;
        $cNombre    =   ($cNombre     == NULL) ? ($cNombre   =  '') : $cNombre;
        $cSlug      =   ($cSlug       == NULL) ? ($cSlug     =  '') : $cSlug;        

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Rol_getListarRoles (?, ?, ?)', [
            $nIdRol,
            $cNombre,
            $cSlug    
        ]);

        return $respuesta;        
    }

    public function getListarPermisosByRol (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdRol     =   $request->nIdRol;
        $nIdRol     =   ($nIdRol      == NULL) ? ($nIdRol    =   0) : $nIdRol;

        $response = DB::select('call sp_Rol_getListarPermisosByRol (?)', [
            $nIdRol
        ]);
        return $response;
    }

    public function setRegistrarRolPermisos (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cNombre    =   $request->cNombre;
        $cSlug      =   $request->cSlug;
        
        $cNombre    =   ($cNombre     == NULL) ? ($cNombre   =  '') : $cNombre;
        $cSlug      =   ($cSlug       == NULL) ? ($cSlug     =  '') : $cSlug;        

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Rol_setRegistrarRol (?, ?)', [
            $cNombre,
            $cSlug    
        ]);

        $nIdRol = $respuesta[0]->nIdRol;

        //  Transacciones
        try 
        {
            DB::beginTransaction();
            $listPermisos       =       $request->listPermisosFilter;
            $listPermisosSize   =       sizeof($listPermisos);

            if ($listPermisos > 0) {
                
                foreach ($listPermisos as $key => $value)
                {

                    if ($value['checked'] == true) {
                        // Mecanismo procedimiento almacenado
                        $respuesta  =   DB::select('call sp_Rol_setRegistrarRolPermiso (?, ?)', [
                            $nIdRol,
                            $value['id']
                        ]);
                    }

                }
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
            // captura algún error ocurrido dentro del bloque "try"
            DB::rollBack();
        }
    }

    public function setEditarRolPermisos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdRol     =   $request->nIdRol;
        $cNombre    =   $request->cNombre;
        $cSlug      =   $request->cSlug;
        
        $nIdRol     =   ($nIdRol      == NULL) ? ($nIdRol    =  '') : $nIdRol;
        $cNombre    =   ($cNombre     == NULL) ? ($cNombre   =  '') : $cNombre;
        $cSlug      =   ($cSlug       == NULL) ? ($cSlug     =  '') : $cSlug;        

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Rol_setEditarRol (?, ?, ?)', [
            $nIdRol,
            $cNombre,
            $cSlug    
        ]);

        //  Transacciones
        try 
        {
            DB::beginTransaction();
            $listPermisos       =       $request->listPermisosFilter;
            $listPermisosSize   =       sizeof($listPermisos);

            if ($listPermisos > 0) {
                
                foreach ($listPermisos as $key => $value)
                {

                    if ($value['checked'] == true) {
                        // Mecanismo procedimiento almacenado
                        $respuesta  =   DB::select('call sp_Rol_setRegistrarRolPermiso (?, ?)', [
                            $nIdRol,
                            $value['id']
                        ]);
                    }

                }
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
            // captura algún error ocurrido dentro del bloque "try"
            DB::rollBack();
        }
    }
}
