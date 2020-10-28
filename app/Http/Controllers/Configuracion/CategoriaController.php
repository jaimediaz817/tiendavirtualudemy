<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    //
    public function getListarCategorias(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $cNombre        =   $request->cNombre;
        $cDescripcion   =   $request->cDescripcion;

        $cNombre        =   ($cNombre           == NULL) ? ($cNombre       =  '') : $cNombre;
        $cDescripcion   =   ($cDescripcion      == NULL) ? ($cDescripcion  =  '') : $cDescripcion;


        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Categoria_getListarCategorias (?, ?)', [
            $cNombre,
            $cDescripcion
        ]);
        return $respuesta;
    }
}
