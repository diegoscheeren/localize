<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PedidoStatus;

class PedidoStatusController extends Controller
{
    public function pesquisar()
    {
        $status = [
            ['id' => 0, 'descricao' => 'Em Aberto'],
            ['id' => 1, 'descricao' => 'Parcialmente Pago'],
            ['id' => 2, 'descricao' => 'Integralmente Pago']
        ];

        return [
            'msg' => 'Pesquisa realizada com sucesso',
            'status' => true,
            'data' => $status
        ];
    }
}
