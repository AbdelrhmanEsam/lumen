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


$router->post('/auth/login', 'AuthController@postLogin');


$router->group(['middleware'=>"auth"], function($router){
    $router->get('/users', 'ExampleController@usres');
    $router->get('/test', 'ExampleController@test');

    $router->get('/services', 'ServiceController@index');
    $router->get('/services/show/{id}', 'ServiceController@show');
    $router->post('/service', 'ServiceController@store');
    $router->post('/service/update', 'ServiceController@update');
    $router->delete('/services/{id}', 'ServiceController@destroy');

    $router->get('/home_services', 'HomeServiceController@index');
    $router->get('/home_services/show/{id}', 'HomeServiceController@show');
    $router->post('/home_service', 'HomeServiceController@store');
    $router->post('/home_service/update', 'HomeServiceController@update');
    $router->delete('/home_services/{id}', 'HomeServiceController@destroy');

    $router->get('/jobs', 'JobController@index');
    $router->get('/job/show/{id}', 'JobController@show');
    $router->post('/job', 'JobController@store');
    $router->post('/job/update', 'JobController@update');
    $router->delete('/job/{id}', 'JobController@destroy');


    $router->post('/job_images', 'JobImageController@store');
    $router->delete('/job_images/{id}', 'JobImageController@destroy');


    $router->get('/contact_us', 'ContactUsController@index');
    $router->post('/contact_us', 'ContactUsController@store');

});
