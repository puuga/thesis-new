<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('hello', 'HelloController@hello');
Route::get('hello/{id}', 'HelloController@helloWithId');

Route::get('message', 'HelloController@messages');
Route::get('message/{id}', ['as' => 'messageId', 'uses' => 'HelloController@messageWithId']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
