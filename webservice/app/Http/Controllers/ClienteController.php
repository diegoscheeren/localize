<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cliente;

class ClienteController extends Controller
{
    public function pesquisar()
    {
        return ['msg' => 'Pesquisa realizada com sucesso', 'status' => true, 'data' => Cliente::all()];
    }

    public function salvar(Request $req)
    {
        $dados = $req->all();
        unset($dados['id']);

        $reg = Cliente::create($dados);

        $resp = $reg->exists
            ? ['msg' => 'Cadastrado com sucesso', 'status' => true]
            : ['msg' => 'Erro ao salvar', 'status' => false];

        return $resp;
    }

    public function atualizar(Request $req)
    {
        $dados = $req->all();

        $reg = Cliente::find($dados['id'])->update($dados);

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
        $reg = Cliente::find($request->id)->delete();

        $resp = $reg
            ? ['msg' => 'Excluido com sucesso', 'status' => true]
            : ['msg' => 'Erro ao excluir', 'status' => false];

        return $resp;
    }
}
