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

use App\Http\Controllers\UsersController;

$router->get('/', function () use ($router) {
    return 'Funcionando';
});

$router->post('/cadastrar', 'UsersController@create');
$router->get('/buscar/usuarios', 'UsersController@all');
$router->get('/buscar/usuario/{email}', 'UsersController@findByEmail');
