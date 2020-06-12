<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/auth'], function () use ($router) {
    $router->post('/', 'AccountController@actionLogin');
    $router->post('/confirm', 'AccountController@actionVerify');
});

$router->group(['prefix' => 'api/user'], function () use ($router) {
    $router->get('/', 'AccountController@actionAll');
    $router->get('/{id}', 'AccountController@actionView');
    $router->post('/create', 'AccountController@actionCreate');
    $router->post('/update', 'AccountController@actionUpdate');
    $router->get('/delete/{id}', 'AccountController@actionDelete');
});


$router->group(['prefix' => 'api/market'], function () use ($router) {
    $router->get('/', 'MarketController@actionAll');
    $router->get('/{id}', 'MarketController@actionView');
    $router->post('/create', 'MarketController@actionCreate');
    $router->post('/udpate', 'MarketController@actionUpdate');
    $router->post('/openmt', 'MarketController@actionOpenMt');
});


$router->group(['prefix' => 'api/product'], function () use ($router) {
    $router->get('/', 'ProductController@actionAll');
    $router->get('/{id}', 'ProductController@actionList');
    $router->post('/create','ProductController@actionCreate');
    $router->post('/delete', 'ProductController@actionDelete');
});
