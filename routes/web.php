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

$router->group(['prefix' => 'books'], function ($router) {
    $router->get('/', [
        'as' => 'books', 'uses' => 'BooksController@get'
    ]);
    $router->get('/{id}', [
        'as' => 'books', 'uses' => 'BooksController@getBookById'
    ]);
    $router->post('/', [
        'as' => 'books', 'uses' => 'BooksController@post'
    ]);
    $router->put('/{id}', [
        'as' => 'books', 'uses' => 'BooksController@put'
    ]);
    $router->delete('/{id}', [
        'as' => 'books', 'uses' => 'BooksController@delete'
    ]);
});
$router->group(['prefix' => 'authors'], function ($router) {
    $router->get('/', [
        'as' => 'authors', 'uses' => 'AuthorsController@get'
    ]);
    $router->post('/', [
        'as' => 'authors', 'uses' => 'AuthorsController@post'
    ]);
    $router->put('/{id}', [
        'as' => 'authors', 'uses' => 'AuthorsController@put'
    ]);
    $router->delete('/{id}', [
        'as' => 'authors', 'uses' => 'AuthorsController@delete'
    ]);
});
$router->group(['prefix' => 'comments'], function ($router) {
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
    $router->get('/book/{id}', [
        'as' => 'characters', 'uses' => 'CharactersController@getCharacterByBookId'
    ]);

    $router->post('/', [
        'as' => 'characters', 'uses' => 'CharactersController@post'
    ]);

});







