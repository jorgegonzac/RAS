<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'SessionsController@create');

Route::get('login', 'SessionsController@create');

Route::post('login', 'SessionsController@authenticate');

Route::get('logout', 'SessionsController@destroy');

Route::resource('users','UsersController');

Route::resource('tickets','TicketsController');

Route::resource('dReports','DReportsController');

Route::get('student', 'StudentsController@home');

Route::get('parent', 'ParentsController@home');

Route::get('admin', 'AdminsController@home');
