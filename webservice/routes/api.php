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
Route::post('/cadastro', ['as' => 'cadastro', 'uses' => 'AuthController@cadastrar']);
Route::post('/cadastro/item', ['as' => 'cadastro', 'uses' => 'ItemController@salvar']);
Route::post('/login', ['as' => 'login', 'uses' => 'AuthController@login']);

Route::middleware('auth:api')->get('/usuario', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->put('/perfil', ['as' => 'perfil', 'uses' => 'AuthController@perfil']);
