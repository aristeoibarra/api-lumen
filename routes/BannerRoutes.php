<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/banner'], function () use ($router) {
    $router->get('/', 'BannerController@index');
    $router->get('/{id}', 'BannerController@show');
    $router->post('/', 'BannerController@store');
    $router->put('/{id}', 'BannerController@update');
    $router->delete('/{id}', 'BannerController@destroy');
});
