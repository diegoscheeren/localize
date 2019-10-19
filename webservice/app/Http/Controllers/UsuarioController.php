<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UsuarioController extends Controller
{
    public function pesquisar()
    {
        return [
            'msg' => 'Pesquisa realizada com sucesso',
            'status' => true,
            'data' => User::all()
        ];
    }

    public function salvar(Request $req)
    {
        $dados = $req->all();
        unset($dados['id']);

        if ($dados['password'] !== $dados['confirm_password']) {
            return ['msg' => 'Senhas de confirmação não confere', 'status' => false];
        }

        $dados['password'] = bcrypt($dados['password']);

        $reg = User::create($dados);

        $resp = $reg->exists
            ? ['msg' => 'Cadastrado com sucesso', 'status' => true]
            : ['msg' => 'Erro ao salvar', 'status' => false];

        return $resp;
    }

    public function atualizar(Request $req)
    {
        $dados = $req->all();

        $reg = User::find($dados['id'])->update($dados);

        $resp = $reg
            ? ['msg' => 'Editado com sucesso', 'status' => true]
            : ['msg' => 'Erro ao editar', 'status' => false];

        return $resp;
    }

    public function deletar(Request $request)
    {
        $reg = User::find($request->id)->delete();

        $resp = $reg
            ? ['msg' => 'Excluido com sucesso', 'status' => true]
            : ['msg' => 'Erro ao excluir', 'status' => false];

        return $resp;
    }
}
