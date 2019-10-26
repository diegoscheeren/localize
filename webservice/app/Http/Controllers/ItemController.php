<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Item;

class ItemController extends Controller
{
    public function pesquisar()
    {
        return [
            'msg' => 'Pesquisa realizada com sucesso',
            'status' => true,
            'data' => Item::with('unidadeMedida', 'itemGrupo')->get()
        ];
    }

    public function salvar(Request $req)
    {
        $dados = $req->all();
        unset($dados['id']);

        // if ($req->hasFile('imagem')) {
        //     $imagem = $req->file('imagem');
        //     $num = rand(1111, 9999);
        //     $dir = 'img/itens/';
        //     $extensao = $imagem->guessClientExtension();
        //     $nomeImagem = $num . $extensao;
        //     $imagem->move($dir, $nomeImagem);

        //     $dados['imagem'] = "{$dir}/{$nomeImagem}";
        // }

        $reg = Item::create($dados);

        $resp = $reg->exists
            ? ['msg' => 'Cadastrado com sucesso', 'status' => true]
            : ['msg' => 'Erro ao salvar', 'status' => false];

        return $resp;
    }

    public function atualizar(Request $req)
    {
        $dados = $req->all();
        // return $dados;

        // if ($req->hasFile('imagem')) {
        //     $imagem = $req->file('imagem');
        //     $num = rand(1111, 9999);
        //     $dir = 'img/itens/';
        //     $extensao = $imagem->guessClientExtension();
        //     $nomeImagem = $num . $extensao;
        //     $imagem->move($dir, $nomeImagem);

        //     $dados['imagem'] = "{$dir}/{$nomeImagem}";
        // }

        $reg = Item::find($dados['id'])->update($dados);

        $resp = $reg
            ? ['msg' => 'Editado com sucesso', 'status' => true]
            : ['msg' => 'Erro ao editar', 'status' => false];

        return $resp;
    }

    public function deletar(Request $request)
    {
        $reg = Item::find($request->id)->delete();

        $resp = $reg
            ? ['msg' => 'Excluido com sucesso', 'status' => true]
            : ['msg' => 'Erro ao excluir', 'status' => false];

        return $resp;
    }

    public function estoqueEntrada(Request $request)
    {
        $dados = $request->all();

        $item = Item::find($dados['id']);
        $item->estoque += $dados['estoque'];
        $item->valor_custo = $dados['valor_custo'];
        $item->valor_venda = $dados['valor_venda'];
        // $item->observacao = $dados['valor_custo'];

        $reg = $item->save();

        $resp = $reg
            ? ['msg' => 'Entrada de estoque concluida', 'status' => true]
            : ['msg' => 'Erro na operação', 'status' => false];

        return $resp;
    }
}
