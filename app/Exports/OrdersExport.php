<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    use Exportable;
    private $listPedidos = [];
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    public function getPedidos(int $listPedidos)
    {
        $this->listPedidos = $listPedidos;

        return $this;
    }
}
