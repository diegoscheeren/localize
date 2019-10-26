<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pedido;
use App\PedidoItem;

class PedidoController extends Controller
{
    public function pesquisar(Request $req)
    {
        $pedidos = null;
        if ($req->filter != 'false') {
            $pedidos = Pedido::with('pedidoCliente', 'pedidoGarcom')
                ->where('finalizado', '=', 'false')->get();
        } else {
            $pedidos = Pedido::with('pedidoCliente', 'pedidoGarcom')->get();
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
        $resp = [];
        $success = true;
        $dados = $req->all();
        $itens = $dados['itens'];

        $pedido = Pedido::find($dados['id'])->update($dados);

        if ($pedido) {
            PedidoItem::where('pedido', '=', $dados['id'])->delete();
            foreach ($itens as $item) {
                $success = PedidoItem::create([
                    'pedido' => $dados['id'],
                    'item' => $item['id'],
                    'quantidade' => $item['quantidade']
                ]) ? $success : false;
            }
            $resp = $success
                ? ['msg' => 'Atualizado com sucesso', 'status' => true]
                : ['msg' => 'Erro ao atualizar itens no pedido', 'status' => false];
        } else {
            $resp = ['msg' => 'Erro ao atualizar pedido', 'status' => false];
        }

        return $resp;
    }

    public function deletar(Request $request)
    {
        if (Pedido::find($request->id)->delete()) {
            PedidoItem::where('pedido', '=', $request->id)->delete();
            $resp = ['msg' => 'Excluido com sucesso', 'status' => true];
        } else {
            $resp = ['msg' => 'Erro ao excluir pedido', 'status' => false];
        }

        return $resp;
    }

    public function itensByPedido(Request $request)
    {
        $dados = $request->all();

        $itens = DB::select(
            "SELECT i.id, i.descricao, ig.descricao grupo, pdi.quantidade, i.valor_venda, i.estoque
            from pedidos_itens pdi
            left join itens i on (pdi.item = i.id)
            left join itens_grupos ig on (i.grupo = ig.id)
            left join pedidos p on (pdi.pedido = p.id)
            where pdi.pedido={$dados['id']}"
        );

        $resp = $itens
            ? ['msg' => 'Itens carregados com sucesso', 'status' => true, 'data' => $itens]
            : ['msg' => 'Erro ao buscar itens', 'status' => false];

        return $resp;
    }

    public function finalizar(Request $request)
    {
        $dados = $request->all();
        $dados['finalizado'] = true;

        $pedido = Pedido::find($dados['pedido'])->update($dados);

        $resp = $pedido
            ? ['msg' => 'Finalizado com sucesso', 'status' => true]
            : ['msg' => 'Erro ao finalizar pedido', 'status' => false];

        return $resp;
    }
}
