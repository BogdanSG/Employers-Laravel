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

Auth::routes();

Route::get('/', 'AppController@home');

Route::get('/home', 'AppController@home')->name('home');

Route::get('/logout', 'AppController@logout')->name('logout');

Route::get('/treeview', 'AppController@treeview')->name('treeview');

Route::get('/single-employee/{id}', 'AppController@singleEmployee');

Route::group(['middleware' => ['auth']], function(){

});
