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

        
        //     echo "NIDROL  : " . $nIdRol;
        //     var_dump($request->listPermisosFilter);
        //     echo "resp::: \n";
        //     var_dump($respuesta[0]->nIdRol);
        // exit;



        //  Transacciones
        try 
        {
            DB::beginTransaction();            

            // Mecanismo procedimiento almacenado
            $respuesta  =   DB::select('call sp_Rol_setRegistrarRol (?, ?)', [
                $cNombre,
                $cSlug    
            ]);

            $nIdRol = $respuesta[0]->nIdRol;

            $listPermisos       =       $request->listPermisosFilter;
            $listPermisosSize   =       sizeof($listPermisos);

            if ($listPermisosSize > 0) {
                
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
            return json_encode(["sucess" => 817]);
        }
        catch (Exception $e)
        {
            // captura algún error ocurrido dentro del bloque "try"
            DB::rollBack();
            return json_encode(["sucess" => 718, "error:" => $e]);
            //echo "ojo:::::::::::::::::";

        }
    }

    public function setEditarRolPermisos(Request $request)
    {
        $respuesta = array();

        if (!$request->ajax()) return redirect('/');

        $nIdRol     =   $request->nIdRol;
        $cNombre    =   $request->cNombre;
        $cSlug      =   $request->cSlug;
        
        $nIdRol     =   ($nIdRol      == NULL) ? ($nIdRol    =  0)  : $nIdRol;
        $cNombre    =   ($cNombre     == NULL) ? ($cNombre   =  '') : $cNombre;
        $cSlug      =   ($cSlug       == NULL) ? ($cSlug     =  '') : $cSlug;        

        // TODO: test
        // echo "nIDrOL: $nIdRol , cNombre: $cNombre, cSlug: $cSlug";
        // exit;

        //  Transacciones
        try 
        {
            // echo "nIDrOL: $nIdRol , cNombre: $cNombre, cSlug: $cSlug";
            // var_dump($request); exit;
            
            DB::beginTransaction();

            // Mecanismo procedimiento almacenado
            $respuesta  =   DB::select('call sp_Rol_setEditarRol (?, ?, ?)', [
                $nIdRol,
                $cNombre,
                $cSlug    
            ]);

            $listPermisos       =       $request->listPermisosFilter;
            $listPermisosSize   =       sizeof($listPermisos);

            if ($listPermisosSize > 0) 
            {     
                // var_dump($listPermisos);
                // echo "817 :::::::::::::::";
                //exit;
                foreach ($listPermisos as $key => $value)
                {
                    if ($value['checked'] == true) {
                        // Mecanismo procedimiento almacenado
                        $respuesta  =   DB::select('call sp_Rol_setRegistrarRolPermiso (?, ?)', [
                            $nIdRol,
                            $value['id']
                        ]);
                    }
                    else
                    {

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
}
