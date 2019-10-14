<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_itens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pedido')->references('id')->on('pedidos');
            $table->integer('item')->references('id')->on('itens');
            $table->float('quantidade', 15, 1);
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
        Schema::dropIfExists('pedidos_itens');
    }
}