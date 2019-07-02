<?php

use Illuminate\Http\Request;

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
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('open', 'AuthController@open');
Route::get('mesas', 'GarcomController@mesas');
Route::patch('mesas/{id}', 'GarcomController@atualizaStatusMesa');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('verifytoken', 'AuthController@verificaToken');
    Route::post('/logout', 'AuthController@logout');
    Route::get('closed', 'AuthController@closed');
});
