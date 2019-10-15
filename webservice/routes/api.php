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

//_______________________________ ITEM ____________________________________________//
Route::get('/item', ['as' => 'pesquisar.item', 'uses' => 'ItemController@pesquisar']);
Route::put('/item', ['as' => 'atualizar.item', 'uses' => 'ItemController@atualizar']);
Route::post('/item', ['as' => 'cadastrar.item', 'uses' => 'ItemController@salvar']);
Route::delete('/item', ['as' => 'deletar.item', 'uses' => 'ItemController@deletar']);

//_______________________________ CLIENTE ____________________________________________//
Route::get('/cliente', ['as' => 'pesquisar.cliente', 'uses' => 'ClienteController@pesquisar']);
Route::put('/cliente', ['as' => 'atualizar.cliente', 'uses' => 'ClienteController@atualizar']);
Route::post('/cliente', ['as' => 'cadastrar.cliente', 'uses' => 'ClienteController@salvar']);
Route::delete('/cliente', ['as' => 'deletar.cliente', 'uses' => 'ClienteController@deletar']);
