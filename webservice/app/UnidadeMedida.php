<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeMedida extends Model
{
    protected $table = 'unidade_medidas';

    protected $fillable = ['abreviacao', 'descricao', 'quantidade'];
}
