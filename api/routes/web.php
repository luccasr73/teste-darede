<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', 'AuthController@login');
    $router->post('/cadastrar', 'UsersController@create');
    $router->get('/buscar/usuarios', 'UsersController@findAll');
    $router->get('/buscar/usuario/{email}', 'UsersController@findByEmail');
    $router->get('/versao', function () use ($router) {
        return response()->json(['versao' => '1']);
    });
});