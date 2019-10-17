<?php

namespace App;

use app\comercial\model\entities\pedido\Pedido;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    protected $table = 'pedidos_itens';

    protected $fillable = [
        'id',
        'pedido',
        'item',
        'quantidade'
    ];

    // public function pedido()
    // {
    //     return $this->belongsTo(Pedido::class, 'pedido');
    // }

    // public function item()
    // {
    //     return $this->belongsTo(Item::class, 'item');
    // }
}
