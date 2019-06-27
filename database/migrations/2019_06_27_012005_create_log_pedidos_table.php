<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logPedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mensagem');
            $table->integer('users_id');
            $table->integer('mesas_id');
            $table->integer('pedidos_id');
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('mesas_id')->references('id')->on('mesas');
            $table->foreign('pedidos_id')->references('id')->on('pedidos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logPedidos');
    }
}
