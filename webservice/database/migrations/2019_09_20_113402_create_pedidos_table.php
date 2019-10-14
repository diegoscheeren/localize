<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente')->references('id')->on('clientes')->nullable();
            $table->integer('garcom')->references('id')->on('user')->nullable();
            $table->integer('quantidade_pessoas')->nullable();
            $table->integer('mesa')->nullable();
            $table->float('valor_total', 15, 2)->nullable();
            $table->string('status');
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
        Schema::dropIfExists('pedidos');
    }
}