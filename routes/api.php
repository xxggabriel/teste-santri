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
Route::post('/login', 'Api\\UsuarioController@login');

Route::group(['prefix' => 'usuario'],function(){
    Route::get('/', 'Api\\UsuarioController@index');
    Route::get('/busca', 'Api\\UsuarioController@search');
    Route::get('/{id}', 'Api\\UsuarioController@show');
    Route::post('/criar', 'Api\\UsuarioController@store');
    Route::post('/atualizar/{id}', 'Api\\UsuarioController@update');
    Route::post('/excluir/{id}', 'Api\\UsuarioController@destroy');
});
