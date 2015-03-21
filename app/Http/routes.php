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

// test
Route::group(array('prefix' => 'test'), function() {
	Route::get('message', ['as' => 'messageAll', 'uses' => 'HelloController@messages']);
	Route::get('message/{id}', ['as' => 'messageId', 'uses' => 'HelloController@messageWithId']);
	Route::get('messageform', ['as' => 'newMessageForm', 'uses' => function() { return View::make('hello.messagesForm'); }]);
	Route::post('message/create', ['as' => 'newMessage', 'uses' => 'HelloController@messageCreate']);
});

// Web services
Route::group(array('prefix' => 'api/v1'), function() {

	// hello
	Route::post('message', 'HelloController@createMessage');
	Route::get('message', 'HelloController@getMessages');
	Route::get('message/{id}', 'HelloController@getMessage');
	Route::delete('message/{id}', 'HelloController@deleteMessage');

});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
