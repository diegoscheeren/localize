<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'rg',
        'data_nascimento',
        'email',
        'telefone',
        'municipio',
        'estado',
        'endereco',
        'bairro',
        'numero',
        'complemento'
    ];
}
