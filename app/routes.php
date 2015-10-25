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

Route::get('mySonTickets', ['before' => 'auth', 'uses' => 'ParentsController@showTickets']);

Route::get('mySonDReports', ['before' => 'auth', 'uses' => 'ParentsController@showDReports']);

Route::get('myInfo', ['before' => 'auth', 'uses' => 'ParentsController@showMyInfo']);


/*
Route::get('students', ['before' => 'auth', 'uses' => 'AdminsController@showStudents']);

Route::get('students/create', ['before' => 'auth', 'uses' => 'AdminsController@createStudent']);

Route::post('students/create', ['before' => 'auth', 'uses' => 'AdminsController@storeStudent']);

Route::get('students/{id}/edit', ['before' => 'auth', 'uses' => 'AdminsController@editStudent']);

Route::post('students/update', ['before' => 'auth', 'as' => 'studentUpdate', 'uses' => 'AdminsController@updateStudent']);

Route::delete('students/{id}', ['before' => 'auth', 'uses' => 'AdminsController@deleteStudent']);

Route::get('assistants', ['before' => 'auth', 'uses' => 'AdminsController@showAssistants']);
*/
Route::resource('students','StudentsController');

Route::resource('assistants','AssistantsController');

Route::get('parents', ['before' => 'auth', 'uses' => 'AdminsController@showParents']);

