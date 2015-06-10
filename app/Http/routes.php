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

Route::get('home', array('as' => 'home', 'uses' => 'PagesController@home'));
Route::get('about', array('as' => 'about', 'uses' => 'PagesController@about'));
Route::get('profile', array('as' => 'profile', 'uses' => 'ProfileController@edit'));
Route::patch('profile', array('as' => 'profile.update', 'uses' => 'ProfileController@update'));

// Route::get('users', array('as' => 'users', 'uses' => 'UsersController@index'));
// Route::get('users/create', array('as' => 'createUser', 'uses' => 'UsersController@create'));
// Route::get('users/{id}/edit', array('as' => 'editUser', 'uses' => 'UsersController@edit'));
// Route::get('users/{id}', array('as' => 'viewUser', 'uses' => 'UsersController@view'));
// Route::get('users/{id}/delete', array('as' => 'deleteUser', 'uses' => 'UsersController@delete'));
// Route::post('users', array('as' => 'storeUser', 'uses' => 'UsersController@store'));

Route::resource('users', 'UsersController');
Route::resource('providers', 'ProvidersController');
Route::resource('ports', 'PortsController');
Route::resource('docks', 'DocksController');
Route::resource('bookings', 'BookingsController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
