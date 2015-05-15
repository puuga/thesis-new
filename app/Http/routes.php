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

Route::get('/', 'StoreController@home');

// Route::get('home', 'HomeController@index');
Route::get('home', 'StoreController@home');

// store
Route::group(array('prefix' => 'store'), function() {
	Route::get('/', 'StoreController@home');
	Route::get('content/{id}', [
		'as'=>'contentById',
		'uses'=>'StoreController@contentById']);
	Route::get('category/{id}', [
		'as'=>'categoryById',
		'uses'=>'StoreController@categoryById']);
});

// content
Route::group(array('prefix' => 'contents'), function() {
	Route::get('/new', [
		'as'=>'newContent',
		'uses'=>'ContentController@newContent']);
	Route::post('/create', [
		'as'=>'createContent',
		'uses'=>'ContentController@createContent']);
	Route::post('/{id}/update', [
		'as'=>'updateContent',
		'uses'=>'ContentController@updateContent']);
	Route::get('/design/{id}', [
		'as'=>'designContent',
		'uses'=>'ContentController@designContent']);
	Route::get('/mycontent', [
		'as'=>'myContents',
		'uses'=>'ContentController@myContent']);
});

// image
Route::group(array('prefix' => 'imageentry'), function() {
	Route::get('all', 'ImageEntryController@allImageBelongToUser');
	Route::get('getbyname/{filename}', [
		'as'=>'getimagebyfilename',
		'uses'=>'ImageEntryController@getByFilename']);
	Route::get('getbyid/{filename}', [
		'as'=>'getimagebyid',
		'uses'=>'ImageEntryController@getById']);
	Route::post('add',[
		'as'=>'addimageentry',
		'uses'=>'ImageEntryController@add']);
	Route::post('addtocontent',[
		'as'=>'addimageentrytocontent',
		'uses'=>'ImageEntryController@addToContent']);
});

// Static pages
Route::get('about', [
	'as' => 'about',
	'uses'=>'StaticController@about']);
Route::get('contact', [
	'as' => 'contact',
	'uses'=>'StaticController@contact']);

Route::get('welcome', 'WelcomeController@index');

Route::get('hello', 'HelloController@hello');
Route::get('hello/{id}', 'HelloController@helloWithId');

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

// test
Route::group(array('prefix' => 'test'), function() {
	Route::get('message', [
		'as' => 'messageAll',
		'uses' => 'HelloController@messages']);
	Route::get('message/{id}', [
		'as' => 'messageId',
		'uses' => 'HelloController@messageWithId']);
	Route::get('messageform', [
		'as' => 'newMessageForm',
		'uses' => function() { return View::make('hello.messagesForm'); }]);
	Route::post('message/create', [
		'as' => 'newMessage',
		'uses' => 'HelloController@messageCreate']);
	Route::post('comment/{id}/create', [
		'as' => 'newComment',
		'uses' => 'HelloController@commentCreate']);
});
