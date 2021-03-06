<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/tree-employee', 'Api\ApiController@treeEmployee');

//Route::post('/new-employee-position-chief', 'Api\ApiController@newEmployeePositionChief');
//
//Route::post('/employee-list', 'Api\ApiController@employeeList');

Route::group(['middleware' => ['auth:api']], function(){

    Route::post('/new-employee-position-chief', 'Api\ApiController@newEmployeePositionChief');

    Route::post('/employee-list', 'Api\ApiController@employeeList');

});