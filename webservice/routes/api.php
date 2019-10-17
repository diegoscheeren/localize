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

Route::post('/login', ['as' => 'login', 'uses' => 'AuthController@login']);

Route::middleware('auth:api')->get('/usuario', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->put('/perfil', ['as' => 'perfil', 'uses' => 'AuthController@perfil']);

Route::post('/cadastro', ['as' => 'cadastro', 'uses' => 'AuthController@cadastrar']);

//_______________________________ Item ____________________________________________//
Route::get('/item', ['as' => 'pesquisar.item', 'uses' => 'ItemController@pesquisar']);
Route::put('/item', ['as' => 'atualizar.item', 'uses' => 'ItemController@atualizar']);
Route::post('/item', ['as' => 'cadastrar.item', 'uses' => 'ItemController@salvar']);
Route::delete('/item', ['as' => 'deletar.item', 'uses' => 'ItemController@deletar']);

//_______________________________ Cliente ____________________________________________//
Route::get('/cliente', ['as' => 'pesquisar.cliente', 'uses' => 'ClienteController@pesquisar']);
Route::put('/cliente', ['as' => 'atualizar.cliente', 'uses' => 'ClienteController@atualizar']);
Route::post('/cliente', ['as' => 'cadastrar.cliente', 'uses' => 'ClienteController@salvar']);
Route::delete('/cliente', ['as' => 'deletar.cliente', 'uses' => 'ClienteController@deletar']);

//_______________________________ Pedido ____________________________________________//
Route::get('/pedido', ['as' => 'pesquisar.pedido', 'uses' => 'PedidoController@pesquisar']);
Route::put('/pedido', ['as' => 'atualizar.pedido', 'uses' => 'PedidoController@atualizar']);
Route::post('/pedido', ['as' => 'cadastrar.pedido', 'uses' => 'PedidoController@salvar']);
Route::delete('/pedido', ['as' => 'deletar.pedido', 'uses' => 'PedidoController@deletar']);

//_______________________________ Unidade de Medida _____________________________________//
Route::get('/unidade-medida', ['as' => 'pesquisar.unidade-medida', 'uses' => 'UnidadeMedidaController@pesquisar']);
Route::put('/unidade-medida', ['as' => 'atualizar.unidade-medida', 'uses' => 'UnidadeMedidaController@atualizar']);
Route::post('/unidade-medida', ['as' => 'cadastrar.unidade-medida', 'uses' => 'UnidadeMedidaController@salvar']);
Route::delete('/unidade-medida', ['as' => 'deletar.unidade-medida', 'uses' => 'UnidadeMedidaController@deletar']);

//_______________________________ Grupo de Itens __________________________________________//
Route::get('/grupo', ['as' => 'pesquisar.grupo', 'uses' => 'ItemGrupoController@pesquisar']);
Route::put('/grupo', ['as' => 'atualizar.grupo', 'uses' => 'ItemGrupoController@atualizar']);
Route::post('/grupo', ['as' => 'cadastrar.grupo', 'uses' => 'ItemGrupoController@salvar']);
Route::delete('/grupo', ['as' => 'deletar.grupo', 'uses' => 'ItemGrupoController@deletar']);

//_______________________________ Pedido Status __________________________________________//
Route::get('/status', ['as' => 'pesquisar.status', 'uses' => 'PedidoStatusController@pesquisar']);
