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
    Route::get('/projects-add', 'ProjectsController@addForm')->name('projects.add-form');
    Route::post('/projects-add', 'ProjectsController@add')->name('projects.add');
    Route::get('/projects/{project}', 'ProjectsController@updateForm')->name('projects.update-form');
    Route::post('/projects/{project}', 'ProjectsController@update')->name('projects.update');
    /*
     * Удалять сущность через GET-запрос - это так себе решение.
     * Но альтернативы еще хуже.
     */
    Route::get('/projects/{project}/delete', 'ProjectsController@delete')->name('projects.delete');

    Route::get('/projects/{project}/event-types', 'ProjectEventTypesController@index')
        ->name('project.event-types.list');
    Route::get('/projects/{project}/event-types-add', 'ProjectEventTypesController@addForm')
        ->name('project.event-types.add-form');
    Route::post('/projects/{project}/event-types-add', 'ProjectEventTypesController@add')
        ->name('project.event-types.add');
    Route::get('/project-event-types/{event}', 'ProjectEventTypesController@updateForm')
        ->name('project.event-types.update-form');
    Route::post('/project-event-types/{event}', 'ProjectEventTypesController@update')
        ->name('project.event-types.update');
    /**
     * То же самое, что и удаление проекта
     */
    Route::get('/project-event-types/{event}/delete', 'ProjectEventTypesController@delete')->name('project.event-types.delete');

    Route::get('/statistic', 'StatisticController@show')->name('statistic.show');
    Route::get('/logs', 'LogsController@index')->name('logs.list');

});
