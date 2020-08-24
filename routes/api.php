<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//List Students
Route::get('students','StudentController@index');
//login
Route::post('students/auth/signin','StudentController@submit_login');
//register
Route::post('students/auth/register','StudentController@submit_register');
//List student with id
Route::get('student/{id}','StudentController@show');

Route::post('student','StudentController@store');
//Update
Route::put('student','StudentController@store');
//Delete
Route::delete('student/{id}','StudentController@destroy');