<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemGrupo extends Model
{
    protected $table = 'itens_grupos';

    protected $fillable = ['descricao'];
}
