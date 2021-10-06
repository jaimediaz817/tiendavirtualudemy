<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoCrear extends Mailable
{
    use Queueable, SerializesModels;

    protected $respuesta1, $respuesta2, $logo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($respuesta1, $respuesta2, $logo)
    {
        $this->respuesta1 = $respuesta1;
        $this->respuesta2 = $respuesta2;
        $this->logo       = $logo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->respuesta1[0]->cVendedorCorreo)
            ->subject("Empresa de pruebas, Pedido #" . $this->respuesta1[0]->nNumeroPedido)
            ->view('reportes.pedido.pdf.ver')
            ->with([
                'respuesta'  => $this->respuesta1,
                'respuesta2' => $this->respuesta2,
                'logo'       => $this->logo
            ])
            ->attach($this->logo);
    }
}
