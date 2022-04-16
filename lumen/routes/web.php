<?php

$router->group(['prefix' => 'products'], function () use ($router) {
    $router->get('/', 'ProductsController@index');
    $router->get('/{id}', 'ProductsController@show');
    $router->post('/', 'ProductsController@store');
    $router->put('/{id}', 'ProductsController@update');
    $router->delete('/{id}', 'ProductsController@destroy');
});

$router->group(['prefix' => 'orders'], function () use ($router) {
    $router->get('/', 'OrdersController@index');
    $router->get('/{id}', 'OrdersController@show');
    $router->post('/', 'OrdersController@storeOrder');
    $router->put('order-product/{id}', 'OrdersController@update');
    $router->delete('/{id}', 'OrdersController@destroy');
});
