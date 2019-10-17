<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pedido;
use App\PedidoItem;

class PedidoController extends Controller
{
    public function pesquisar()
    {
        $status = [0 => 'Em Aberto', 1 => 'Parcialmente Pago', 2 => 'Integralmente Pago'];

        $pedidos = Pedido::with('pedidoCliente', 'pedidoGarcom')->get();
        foreach ($pedidos as $pedido) {
            $pedido['status'] = [
                'id' => $pedido['status'],
                'descricao' => $status[$pedido['status']]
            ];
        }

        return ['msg' => 'Pesquisa realizada com sucesso', 'status' => true, 'data' => $pedidos];
    }

    public function salvar(Request $req)
    {
        $dados = $req->all();
        unset($dados['id']);

        $resp = [];
        $success = true;
        $itens = $dados['itens'];
        $pedido = Pedido::create($dados);

        if ($pedido->exists) {
            foreach ($itens as $item) {
                $success = PedidoItem::create([
                    'pedido' => $pedido->id,
                    'item' => $item['id'],
                    'quantidade' => $item['quantidade']
                ]) ? $success : false;
            }
            $resp = $success
                ? ['msg' => 'Cadastrado com sucesso', 'status' => true]
                : ['msg' => 'Erro ao salvar itens no pedido', 'status' => false];
        } else {
            $resp = ['msg' => 'Erro ao criar pedido', 'status' => false];
        }

        return $resp;
    }

    public function atualizar(Request $req)
    {
        $dados = $req->all();

        $reg = Pedido::find($dados['id'])->update($dados);

        $resp = $reg
            ? ['msg' => 'Editado com sucesso', 'type' => 'green']
            : ['msg' => 'Erro ao editar', 'type' => 'red'];

        $resp = $reg
            ? ['msg' => 'Editado com sucesso', 'status' => true]
            : ['msg' => 'Erro ao editar', 'status' => false];

        return $resp;
    }

    public function deletar(Request $request)
    {
        $reg = Pedido::find($request->id)->delete();

        $resp = $reg
            ? ['msg' => 'Excluido com sucesso', 'status' => true]
            : ['msg' => 'Erro ao excluir', 'status' => false];

        return $resp;
    }
}
