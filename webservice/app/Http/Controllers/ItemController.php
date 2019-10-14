<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Item;
use App\ItemGrupo;
use App\UnidadeMedida;

class ItemController extends Controller
{
    public function adicionar()
    {
        $unds = UnidadeMedida::all();
        $grupos = ItemGrupo::all();

        return view('cadastro.item.adicionar', compact('unds', 'grupos'));
    }

    public function pesquisar()
    {
        $itens = Item::all();

        return ['msg' => 'Pesquisa realizada com sucesso', 'status' => true, 'data' => $itens];
    }

    public function salvar(Request $req)
    {
        $dados = $req->all();

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

    public function editar($id)
    {
        $registro = Item::find($id);
        $unds = UnidadeMedida::all();
        $grupos = ItemGrupo::all();

        return view('cadastro.item.editar', compact('registro', 'unds', 'grupos'));
    }

    public function atualizar(Request $req, $id)
    {
        $dados = $req->all();

        if ($req->hasFile('imagem')) {
            $imagem = $req->file('imagem');
            $num = rand(1111, 9999);
            $dir = 'img/itens/';
            $extensao = $imagem->guessClientExtension();
            $nomeImagem = $num . $extensao;
            $imagem->move($dir, $nomeImagem);

            $dados['imagem'] = "{$dir}/{$nomeImagem}";
        }

        $reg = Item::find($id)->update($dados);

        $resp = $reg
            ? ['msg' => 'Editado com sucesso', 'type' => 'green']
            : ['msg' => 'Erro ao editar', 'type' => 'red'];

        return redirect()->route('item.pesquisar')->with('response', $resp);
    }

    public function deletar(Request $request)
    {
        $reg = Item::find($request->id)->delete();

        $resp = $reg
            ? ['msg' => 'Excluido com sucesso', 'status' => true]
            : ['msg' => 'Erro ao excluir', 'status' => false];

        return $resp;
    }
}
