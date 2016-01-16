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

/* Login routes: used to provide authentication and handle sessions*/

Route::get('/', 'SessionsController@create');

Route::get('login', 'SessionsController@create');

Route::post('login', 'SessionsController@authenticate');

Route::get('logout', 'SessionsController@destroy');

Route::controller('password', 'RemindersController');

/* Admin routes */

Route::get('admin', ['before' => 'auth', 'uses' => 'AdminsController@home']);

/* Tickets routes */

Route::resource('tickets','TicketsController');

Route::get('takeAttendance', ['before' => 'auth', 'as' => 'takeAttendance', 'uses' => 'TicketsController@showAttendanceList']);

Route::post('saveAttendance', ['before' => 'auth', 'uses' => 'TicketsController@saveAttendanceList']);

/* hot fix */
Route::get('takeAttendanceAdmin/{floor}', ['before' => 'auth', 'as' => 'takeAttendanceAdmin', 'uses' => 'TicketsController@showAttendanceListAdmin']);

Route::post('saveAttendanceAdmin/{floor}', ['before' => 'auth', 'uses' => 'TicketsController@saveAttendanceListAdmin']);
/* hot fix  */

Route::post('adminTickets', ['before' => 'auth', 'uses' => 'TicketsController@storeTicket']);

/* Disciplinary Reports routes */

Route::resource('dReports','DReportsController');

/* Parents routes */

Route::resource('parents','ParentsController');

Route::get('parent', ['before' => 'auth', 'uses' => 'ParentsController@home']);

Route::get('mySonTickets', ['before' => 'auth', 'uses' => 'ParentsController@showTickets']);

Route::get('mySonDReports', ['before' => 'auth', 'uses' => 'ParentsController@showDReports']);

Route::get('createAccount', ['uses' => 'ParentsController@createAccount']);

Route::post('createAccount', ['uses' => 'ParentsController@storeAccount']);

Route::get('myInfo', ['before' => 'auth', 'uses' => 'ParentsController@showMyInfo']);

/* Student routes */

Route::resource('students','StudentsController');

Route::get('student', ['before' => 'auth', 'uses' => 'StudentsController@home']);

Route::get('settings', ['before' => 'auth', 'uses' => 'StudentsController@showSettings']);

Route::post('settings', ['before' => 'auth', 'uses' => 'StudentsController@storeSettings']);

Route::get('importStudents', ['before' => 'auth', 'uses' => 'StudentsController@importStudents']);

Route::post('importStudents', ['before' => 'auth', 'uses' => 'StudentsController@storeStudents']);

/* Resident Assistant routes */

Route::resource('assistants','AssistantsController');

/* Office routes */

Route::get('office', ['before' => 'auth', 'uses' => 'TicketsController@showAttendanceList']);
