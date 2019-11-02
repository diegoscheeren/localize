<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function info()
    {
        $clientesHoje = DB::select(
            "SELECT sum(quantidade_pessoas) count from pedidos p
            where p.finalizado=true and date_trunc('day', updated_at)=date_trunc('day', now())"
        );

        $comandasAbertas = DB::select("SELECT count(id) from pedidos p where p.finalizado=false");

        $vendasMes = DB::select(
            "SELECT count(id) from pedidos p
            where p.finalizado=true and date_trunc('month', updated_at)=date_trunc('month', now())"
        );

        $maisVendidos = DB::select(
            "SELECT ROW_NUMBER() over() || 'º' posicao, * from (
                select i.descricao, sum(pdi.quantidade) quantidade
                from pedidos_itens pdi
                join pedidos p on (p.id=pdi.pedido)
                join itens i on (i.id=pdi.item)
                where p.finalizado=true
                group by i.id
                order by quantidade desc
                limit 3
            ) t"
        );

        $dados = [
            'clientesHoje' => $clientesHoje[0]->count,
            'comandasAbertas' => $comandasAbertas[0]->count,
            'vendasMes' => $vendasMes[0]->count,
            'maisVendidos' => $maisVendidos
        ];

        return ['msg' => 'Pesquisa realizada com sucesso', 'status' => true, 'data' => $dados];
    }
}
