<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'itens';

    protected $fillable = [
        'id',
        'codigo',
        'grupo',
        'unidade_medida',
        'descricao',
        'valor_custo',
        'valor_venda',
        'estoque',
        'imagem'
    ];

    public function unidadeMedida()
    {
        return $this->belongsTo(UnidadeMedida::class, 'unidade_medida');
    }

    public function itemGrupo()
    {
        return $this->belongsTo(ItemGrupo::class, 'grupo');
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedidos_itens', 'id', 'id');
    }
}
