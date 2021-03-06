<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/index', 'UserController@index')->name('index');
Route::get('/myroom', 'UserController@myroom')->name('myroom');
Route::get('/myroom/{room_id}', 'UserController@roomconfig')->name('config');
Route::get('/cancelroom/{room_id}/{borrow_id}', 'UserController@cancelroom')->name('cancel');
Route::get('/deletemyroom/{room_id}/{borrow_id}', 'UserController@deletemyroom')->name('deletemyroom');
Route::get('/usermanagement', 'UserController@usermanagement')->name('usermanagement');
Route::get('/usermanagement/changepw', 'UserController@changepw')->name('changepw');
Route::post('/usermanagement/newpw', 'UserController@newpw')->name('newpw');
Route::get('/timer/{room_id}','UserController@timer')->name('timer');
Route::post('/timer/{room_id}/scan','UserController@scan')->name('scan');
Route::post('/saveroom', 'UserController@saveroom')->name('saveroom');