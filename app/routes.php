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

Route::get('student', ['before' => 'auth', 'uses' => 'StudentsController@home']);

Route::get('parent', ['before' => 'auth', 'uses' => 'ParentsController@home']);

Route::get('admin', ['before' => 'auth', 'uses' => 'AdminsController@home']);

Route::get('takeAttendance', ['before' => 'auth', 'as' => 'takeAttendance', 'uses' => 'TicketsController@showAttendanceList']);

Route::post('saveAttendance', ['before' => 'auth', 'uses' => 'TicketsController@saveAttendanceList']);

Route::post('adminTickets', ['before' => 'auth', 'uses' => 'TicketsController@storeTicket']);

Route::get('createAccount', ['uses' => 'ParentsController@createAccount']);

Route::post('createAccount', ['uses' => 'ParentsController@storeAccount']);
