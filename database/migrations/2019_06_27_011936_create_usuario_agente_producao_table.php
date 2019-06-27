<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioAgenteProducaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarioAgenteProducao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id');
            $table->integer('estacaoProducao_id');
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('estacaoProducao');
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
        Schema::dropIfExists('usuarioAgenteProducao');
    }
}
