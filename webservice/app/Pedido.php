<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'id',
        'mesa',
        'status',
        'garcom',
        'cliente',
        'quantidade_pessoas'
    ];

    public function pedidoCliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente');
    }

    public function pedidoGarcom()
    {
        return $this->belongsTo(User::class, 'garcom');
    }

    public function itens()
    {
        return $this->belongsToMany(Item::class, 'pedidos_itens', 'id', 'id');
    }
}
