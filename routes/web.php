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
    return redirect('/login');
});

Route::get('/login', 'Auth\LoginController@form');
Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::namespace('Web')->middleware('auth')->group(function () {

    Route::get('/projects', 'ProjectsController@index')->name('projects.list');

});
