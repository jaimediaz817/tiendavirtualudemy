<?php

namespace App\Http\Controllers\Operacion;

use Exception;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\PedidoCrear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    //
    public function getListarPedidos(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $cNombre    =   $request->cNombre;
        $cDocumento =   $request->cDocumento;
        $cPedido    =   $request->cPedido;
        $cEstado    =   $request->cEstado;

        $cNombre        =   ($cNombre      == NULL) ? ($cNombre     =  '') : $cNombre;
        $cDocumento     =   ($cDocumento   == NULL) ? ($cDocumento  =  '') : $cDocumento;
        $cPedido        =   ($cPedido      == NULL) ? ($cPedido     =  '') : $cPedido;
        $cEstado        =   ($cEstado      == NULL) ? ($cEstado     =  '') : $cEstado;


        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Pedido_getListarPedidos (?, ?, ?, ?)', [
            $cNombre,
            $cDocumento,
            $cPedido,
            $cEstado
        ]);

        return $respuesta;
    }


    public function setRegistrarPedido (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdCliente       =   $request->nIdCliente;
        $cComentario      =   $request->cComentario;
        $fTotalPedido     =   $request->fTotalPedido;
        $listPedido       =   $request->listPedido;
        $nIdAuthUser      =   Auth::id();

        $cComentario    =   ($cComentario     == NULL) ? ($cComentario   =  '') : $cComentario;

        // echo "test:  " . $nIdCliente;
        // var_dump($listPedido);
        // dd();

        //  Transacciones
        try
        {
            DB::beginTransaction();

            // Mecanismo procedimiento almacenado
            $respuesta  =   DB::select('call sp_Pedido_setRegistrarPedido (?, ?, ?, ?)', [
                $nIdCliente,
                $cComentario,
                $fTotalPedido,
                $nIdAuthUser
            ]);

            $nIdPedido = $respuesta[0]->nIdPedido;

            // Iterando sobre los detalles, productos agregados al pedido
            $listPedido       =       $request->listPedido;
            $listPedidoSize   =       sizeof($listPedido);

            if ($listPedidoSize > 0)
            {
                foreach ($listPedido as $key => $value)
                {
                    // Mecanismo procedimiento almacenado
                    $respuesta  =   DB::select('call sp_Pedido_setRegistrarDetallePedido (?, ?, ?, ?)', [
                        $nIdPedido,
                        $value['nIdProducto'],
                        $value['nStock'],
                        $value['fPrecio'] // SubTotal
                    ]);
                }
            }

            DB::commit();
            return $nIdPedido;
        }
        catch (Exception $e)
        {
            // captura algún error ocurrido dentro del bloque "try"
            DB::rollBack();
            return json_encode(["sucess" => 718, "error:" => $e]);
            //echo "ojo:::::::::::::::::";

        }
    }

    public function setGenerarDocumento(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdPedido       =   $request->nIdPedido;
        $logo = asset('img/AdminLTELogo.png');

        $respuesta  =   DB::select('call sp_Pedido_getPedido (?)', [
            $nIdPedido
        ]);

        // Detalle
        $respuestaDetallePedido = DB::select('call sp_Pedido_getDetallePedido (?)', [
            $nIdPedido
        ]);

        $pdf = PDF::loadView('reportes.pedido.pdf.ver', [
            'respuesta'  => $respuesta,
            'respuesta2' => $respuestaDetallePedido,
            'logo'       => $logo
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function setGenerarEmail(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $logo = asset('img/AdminLTELogo.png');
        $nIdPedido  =   $request->nIdPedido;
        $respuesta  =   DB::select('call sp_Pedido_getPedido (?)', [
            $nIdPedido
        ]);

        $respuestaDetallePedido = DB::select('call sp_Pedido_getDetallePedido (?)', [
            $nIdPedido
        ]);

        $emailResponse = null;

        // Validando que el cliente tenga correo
        if ($respuesta[0]->cCorreo)
        {
            $emailResponse = Mail::to($respuesta[0]->cCorreo)->send(
                new PedidoCrear($respuesta, $respuestaDetallePedido, $logo)
            );
        }

        return json_encode(
            $nIdPedido,
            $emailResponse
        );
    }

    public function setCambiarEstadoPedido(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $nIdPedido   =   $request->nIdPedido;
        $cEstado     =   $request->cEstado;
        $nIdAuthUser =   Auth::id();
        $nIdPedido   =   ($nIdPedido   == NULL) ? ($nIdPedido =   0) :  $nIdPedido;
        $cEstado     =   ($cEstado     == NULL) ? ($cEstado   =   0) :  $cEstado;

        // echo "pedido: $nIdPedido, estrado: $cEstado";
        // dd();

        // Mecanismo procedimiento almacenado
        $respuesta  =     DB::select('call sp_Pedido_setCambiarEstadoPedido (?, ?, ?)', [
            $nIdPedido,
            $cEstado,
            $nIdAuthUser
        ]);

        return $respuesta;
    }
}

// .test::before {
//     content: "";
//     position: absolute;
//     top: 0;
//     background: blue;
//     position: fixed;
//     width: 100%;
//     height: 100%;
//     left: 0;
//     z-index: 0;
// }
