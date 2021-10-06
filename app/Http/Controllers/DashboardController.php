<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function getProductosMasVendidos(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Dashboard_getProductosMasVendidos');

        return $respuesta;
    }

    public function getVentasPorDia(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Dashboard_getVentasPorDia');

        return $respuesta;
    }
}
