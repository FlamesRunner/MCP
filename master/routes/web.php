<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    return view('welcome');
	return redirect(route("home"));
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/users', 'AdminController@userList')->name('adminUserList');
Route::post('/admin/users/act', 'AdminController@userAct')->name('adminUserAct');
Route::get('/admin/profile/{email}', 'AdminController@editUserPage')->name('editUserPage');
Route::post('/admin/profile/{email}/save', 'AdminController@editUser')->name('editUser');
Route::get('/profile', 'UserController@updatePage')->name('profile')->middleware('verified');
Route::post('/profile/update', 'UserController@update')->name('updatePageProcess')->middleware('verified');
Route::post('/servers/process/add', 'MCServerController@addServer')->name('addServerProcess');
Route::post('/servers/process/delete', 'MCServerController@deleteServer')->name('deleteServerProcess');
Route::get('/servers/add', 'MCServerController@addServerPage')->name('addServer');
Route::get('/servers', 'MCServerController@listServers')->name('listServers');
Route::get('/servers/manage/{host}', 'MCServerController@manageServerPage')->name('manageServerPage');
Route::get('/servers/manage/{host}/console', 'MCServerController@consoleLog')->name('consoleLog');
Route::get('/servers/manage/{host}/status', 'MCServerController@serverStatus')->name('serverStatus');
Route::get('/servers/manage/{host}/fm', 'MCServerController@fileManager')->name('fileManager');
Route::post('/servers/manage/{host}/saveSettings', 'MCServerController@saveSettings')->name('saveSettings');
Route::get('/servers/manage/{host}/settings', 'MCServerController@serverSettings')->name('serverSettings');
Route::get('/servers/manage/{host}/power/{status}', 'MCServerController@changePowerLevel')->name('changePowerLevel');
Route::post('/servers/manage/{host}/cmd', 'MCServerController@serverCmd')->name('serverCmd');
Route::get('/servers/ping/{host}', 'MCServerController@pingServer')->name('serverPing');
