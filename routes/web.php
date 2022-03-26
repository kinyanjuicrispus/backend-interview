<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'books'], function ($router) {
    $router->get('/', [
        'as' => 'books', 'uses' => 'BooksController@get'
    ]);
    $router->get('/{id}', [
        'as' => 'books', 'uses' => 'BooksController@getBookById'
    ]);

});

$router->group(['prefix' => 'comments'], function ($router) {
    $router->get('/', [
        'as' => 'comments', 'uses' => 'CommentsController@getAll'
    ]);
    $router->get('/{id}', [
        'as' => 'comments', 'uses' => 'CommentsController@get'
    ]);
    $router->post('/', [
        'as' => 'comments', 'uses' => 'CommentsController@post'
    ]);
    $router->put('/{id}', [
        'as' => 'comments', 'uses' => 'CommentsController@put'
    ]);
    $router->delete('/{id}', [
        'as' => 'comments', 'uses' => 'CommentsController@delete'
    ]);
});
$router->group(['prefix' => 'characters'], function ($router) {
    $router->get('/', [
        'as' => 'characters', 'uses' => 'CharactersController@get'
    ]);
    $router->get('/{id}', [
        'as' => 'characters', 'uses' => 'CharactersController@getCharacterById'
    ]);

});







