<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('login', 'AuthController@login');
Route::get('open', 'AuthController@open');

//Rotas protegidas
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('verifytoken', 'AuthController@verificaToken');
    Route::post('logout', 'AuthController@logout');
    Route::get('closed', 'AuthController@closed');
    Route::get('nivelacesso', 'AuthController@nivelAcesso');

//Rotas do Garçom
    Route::get('mesas', 'GarcomController@mesas');
    Route::patch('mesas/{id}', 'GarcomController@abrirMesa');
    Route::get('itensmesa/{id}', 'PedidoController@itensPedidoMesa');
    Route::post('adicionaritem/{id}', 'PedidoController@adicionarItemPedido');
    Route::get('produtos', 'GarcomController@listaProdutos');
    Route::patch('fecharpedido/{id}', 'GarcomController@fecharPedido');

//Rotas do Agente de Produção
    Route::get('estacao/{id}', 'EstacaoController@listarItensEstacao');
    Route::post('itemfinalizado/{id}', 'EstacaoController@confirmarPreparo');
    Route::post('processofinalizado/{id}', 'EstacaoController@finalizarProcesso');

//Rotas do Financeiro
    Route::post('registrargarcom', 'FinanceiroController@registrarGarcom');
    Route::post('registraragente', 'FinanceiroController@registrarAgenteProducao');
    Route::get('listaragentesproducao', 'FinanceiroController@listarAgentesProducao');
    Route::get('listargarcons', 'FinanceiroController@listarGarcons');
    Route::post('cadastrarmesa', 'FinanceiroController@cadastrarMesa');
    Route::post('produto', 'FinanceiroController@cadastraProduto');

});
