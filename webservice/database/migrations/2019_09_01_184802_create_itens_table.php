<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('codigo');
            $table->integer('grupo')->references('id')->on('itens_grupos');
            $table->integer('unidade_medida')->references('id')->on('unidade_medidas');
            $table->string('descricao');
            $table->string('imagem')->nullable();
            $table->float('valor_custo', 15, 2);
            $table->float('valor_venda', 15, 2);
            $table->float('estoque', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens');
    }
}
