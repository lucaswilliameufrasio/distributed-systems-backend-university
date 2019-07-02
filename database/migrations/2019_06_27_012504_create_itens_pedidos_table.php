<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itensPedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pedidos_id');
            $table->integer('produtos_id');
            $table->integer('estacaoProducao_id');
            $table->boolean('statusItemPedido');
            $table->timestamps();
            $table->foreign('pedidos_id')->references('id')->on('pedidos');
            $table->foreign('produtos_id')->references('id')->on('produtos');
            $table->foreign('estacaoProducao_id')->references('id')->on('estacaoProducao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itensPedidos');
    }
}
