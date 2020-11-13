<?php

namespace App\Http\Controllers\Operacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $nIdEstado  =   $request->nIdEstado;        
        
        $cNombre        =   ($cNombre      == NULL) ? ($cNombre     =  '') : $cNombre;
        $cDocumento     =   ($cDocumento   == NULL) ? ($cDocumento  =  '') : $cDocumento;
        $cPedido        =   ($cPedido      == NULL) ? ($cPedido     =  '') : $cPedido;
        $nIdEstado      =   ($nIdEstado    == NULL) ? ($nIdEstado   =   0) : $nIdEstado;        


        // Mecanismo procedimiento almacenado
        $respuesta  =   DB::select('call sp_Pedido_getListarPedidos (?, ?, ?, ?)', [
            $cNombre,
            $cDocumento,
            $cPedido,
            $nIdEstado
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
                        $value['fSubTotal']
                    ]);
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


}
