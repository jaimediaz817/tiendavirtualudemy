<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    //
    public function getListarPedidos(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $cNombre        =   $request->cNombre;
        $cDocumento     =   $request->cDocumento;
        $cPedido        =   $request->cPedido;
        $cEstado        =   $request->cEstado;
        $dFechaInicio   =   $request->dFechaInicio;
        $dFechaFin      =   $request->dFechaFin;

        $cNombre        =   ($cNombre      == NULL) ? ($cNombre      =  '') : $cNombre;
        $cDocumento     =   ($cDocumento   == NULL) ? ($cDocumento   =  '') : $cDocumento;
        $cPedido        =   ($cPedido      == NULL) ? ($cPedido      =  '') : $cPedido;
        $cEstado        =   ($cEstado      == NULL) ? ($cEstado      =  '') : $cEstado;
        $dFechaInicio   =   ($dFechaInicio == NULL) ? ($dFechaInicio =  '') : $dFechaInicio;
        $dFechaFin      =   ($dFechaFin    == NULL) ? ($dFechaFin    =  '') : $dFechaFin;


        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Reportes_getListarPedidos (?, ?, ?, ?, ?, ?)', [
            $cNombre,
            $cDocumento,
            $cPedido,
            $cEstado,
            $dFechaInicio,
            $dFechaFin,
        ]);

        return $respuesta;
    }

    public function export(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $listPedidos = $request->listPedidos;

        return (new OrdersExport)->getPedidos($listPedidos)->download('pedidos.xlsx');
        // return Excel::download(new UsersExport, 'users.xlsx');
    }
}
