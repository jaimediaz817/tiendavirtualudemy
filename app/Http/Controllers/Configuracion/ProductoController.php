<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    //
    public function getListarProductostmp(Request $request)
    {
        // ...
        
    }

    //
    public function getListarProductos(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        
        $nIdProducto    =   $request->nIdProducto;        
        $cNombre        =   $request->cNombre;
        $cDescripcion   =   $request->cDescripcion;
        $nIdCategoria   =   $request->nIdCategoria;        
        
        $nIdProducto    =   ($nIdProducto       == NULL) ? ($nIdProducto   =   0) : $nIdProducto;
        $cNombre        =   ($cNombre           == NULL) ? ($cNombre       =  '') : $cNombre;
        $cDescripcion   =   ($cDescripcion      == NULL) ? ($cDescripcion  =  '') : $cDescripcion;
        $nIdCategoria   =   ($nIdCategoria      == NULL) ? ($nIdCategoria  =   0) : $nIdCategoria;        


        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Producto_getListarProductos (?, ?, ?, ?)', [
            $nIdProducto,
            $cNombre,
            $cDescripcion,
            $nIdCategoria
        ]);

        return $respuesta;
    }    

    public function setRegistrarProducto(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $cNombre        =   $request->cNombre;
        $cDescripcion   =   $request->cDescripcion;
        $nStock         =   $request->nStock;
        $fPrice         =   $request->fPrice;
        $nIdCategoria   =   $request->nIdCategoria;
        $nIdAuthUser    =   Auth::id();

        $cNombre        =   ($cNombre           == NULL) ? ($cNombre       =  '') : $cNombre;
        $cDescripcion   =   ($cDescripcion      == NULL) ? ($cDescripcion  =  '') : $cDescripcion;
        $nStock         =   ($nStock            == NULL) ? ($nStock        =   0) : $nStock;
        $fPrice         =   ($fPrice            == NULL) ? ($fPrice        =   0) : $fPrice;
        $nIdCategoria   =   ($nIdCategoria      == NULL) ? ($nIdCategoria  =  '') : $nIdCategoria;

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Producto_setRegistrarProducto (?, ?, ?, ?, ?, ?)', [
            $cNombre,
            $cDescripcion,
            $nStock,
            $fPrice,
            $nIdCategoria,
            $nIdAuthUser
        ]);
        return $respuesta;
    }    

    public function setEditarProducto(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $nIdProducto    =   $request->nIdProducto;
        $cNombre        =   $request->cNombre;
        $cDescripcion   =   $request->cDescripcion;
        $nStock         =   $request->nStock;
        $fPrice         =   $request->fPrecio;
        $nIdCategoria   =   $request->nIdCategoria;
        $nIdAuthUser    =   Auth::id();

        $nIdProducto    =   ($nIdProducto       == NULL) ? ($nIdProducto   =  '') : $nIdProducto;
        $cNombre        =   ($cNombre           == NULL) ? ($cNombre       =  '') : $cNombre;
        $cDescripcion   =   ($cDescripcion      == NULL) ? ($cDescripcion  =  '') : $cDescripcion;
        $nStock         =   ($nStock            == NULL) ? ($nStock        =   0) : $nStock;
        $fPrice         =   ($fPrice            == NULL) ? ($fPrice        =   0) : $fPrice;
        $nIdCategoria   =   ($nIdCategoria      == NULL) ? ($nIdCategoria  =  '') : $nIdCategoria;

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Producto_setEditarProducto (?, ?, ?, ?, ?, ?, ?)', [
            $nIdProducto,
            $cNombre,
            $cDescripcion,
            $nStock,
            $fPrice,
            $nIdCategoria,
            $nIdAuthUser
        ]);
        return $respuesta;
    }
}
