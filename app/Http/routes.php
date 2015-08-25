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

// Route::get('seedusera', 'UserController@createSeedUserA');
// Route::get('seeduserb', 'UserController@createSeedUserB');

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

// user
Route::group(array('prefix' => 'user'), function() {
	Route::get('history', [
		'as'=>'histories',
		'uses'=>'UserController@histories']);
});

// play
Route::group(array('prefix' => 'play'), function() {
	Route::get('/{id}', [
		'as'=>'play',
		'uses'=>'PlayController@play']);
	Route::get('score/{history_id}', [
		'as'=>'scoreByHistory',
		'uses'=>'PlayController@scoreByHistory']);
	Route::get('activity/{id}', [
		'as'=>'getActivities',
		'uses'=>'PlayController@getActivities']);
	Route::post('/track', [
		'as'=>'trackInteractivity',
		'uses'=>'PlayController@track']);
});

// content
Route::group(array('prefix' => 'contents'), function() {
	Route::get('/all', [
		'as'=>'allContents',
		'uses'=>'ContentController@allContents']);
	Route::get('/new', [
		'as'=>'newContent',
		'uses'=>'ContentController@newContent']);
	Route::post('/create', [
		'as'=>'createContent',
		'uses'=>'ContentController@createContent']);
	Route::post('/{id}/update', [
		'as'=>'updateContent',
		'uses'=>'ContentController@updateContent']);
	Route::get('/{id}/design', [
		'as'=>'designContent',
		'uses'=>'ContentController@designContent']);
	Route::get('/{id}/history', [
		'as'=>'contentHistory',
		'uses'=>'ContentController@contentHistory']);
	Route::get('/{id}/history/{history_id}', [
		'as'=>'contentScoreByHistory',
		'uses'=>'ContentController@scoreByHistory']);
	Route::get('/mycontent', [
		'as'=>'myContents',
		'uses'=>'ContentController@myContent']);
	Route::post('/{contentId}/createactivity', [
		'as'=>'createActivity',
		'uses'=>'ContentController@createActivity']);
	Route::post('/changeactivityorder', [
		'as'=>'changeactivityorder',
		'uses'=>'ContentController@changeActivityOrder']);
	Route::post('/deleteactivity', [
		'as'=>'deleteactivity',
		'uses'=>'ContentController@deleteActivity']);
	Route::get('/designactivity/{id}', [
		'as'=>'designActivity',
		'uses'=>'ContentController@designActivity']);
	Route::post('/updateactivityinformation', [
		'as'=>'updateActivityInformation',
		'uses'=>'ContentController@updateActivityInformation']);
	Route::post('/updateactivityanimation', [
		'as'=>'updateActivityAnimation',
		'uses'=>'ContentController@updateActivityAnimation']);
});

// monitor
Route::group(array('prefix' => 'monitor'), function() {
	Route::get('/mycontent', [
		'as'=>'mMyContents',
		'uses'=>'MonitorController@myContent']);
	Route::get('{id}/monitorDetail', [
		'as'=>'monitorDetail',
		'uses'=>'MonitorController@monitorDetail']);
	Route::get('{id}/monitorDetail/{history_id}', [
		'as'=>'monitorDetailByHistory',
		'uses'=>'MonitorController@monitorDetailByHistory']);
});

// admin
Route::group(array('prefix' => 'admin'), function() {
	Route::get('/home', [
		'as'=>'adminHome',
		'uses'=>'AdminController@home']);

	// user
	Route::group(array('prefix' => 'user'), function() {
		Route::get('/', [
			'as'=>'userList',
			'uses'=>'UserController@userList']);
		Route::get('/switchpermission/{id}', [
			'as'=>'switchPermission',
			'uses'=>'UserController@switchPermission']);
		Route::get('/grantadmin/{id}', [
			'as'=>'grantAdmin',
			'uses'=>'UserController@grantAdmin']);
	});

	// school
	Route::group(array('prefix' => 'school'), function() {
		Route::get('/', [
			'as'=>'schoolList',
			'uses'=>'SchoolController@schoolList']);
		Route::post('/create', [
			'as'=>'createSchool',
			'uses'=>'SchoolController@createSchool']);
	});

	// category
	Route::group(array('prefix' => 'category'), function() {
		Route::get('/', [
			'as'=>'categoryList',
			'uses'=>'CategoryController@categoryList']);
		Route::post('/create', [
			'as'=>'createCategory',
			'uses'=>'CategoryController@createCategory']);
	});

	// content
	Route::group(array('prefix' => 'content'), function() {
		Route::get('/', [
			'as'=>'contentList',
			'uses'=>'AdminController@contentList']);
	});

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
	Route::post('addwithresponse',[
		'as'=>'addWithResponse',
		'uses'=>'ImageEntryController@addWithResponse']);
	Route::post('addtocontent',[
		'as'=>'addimageentrytocontent',
		'uses'=>'ImageEntryController@addToContent']);
	Route::post('addtoactivity',[
		'as'=>'addimageentrytoctivity',
		'uses'=>'ImageEntryController@addToActivity']);
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
