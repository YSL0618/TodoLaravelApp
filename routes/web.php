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
Route::get('/folders/share/{share}', 'TaskController@showTaskShare')->name('tasks.show_share');

Route::get('/folders/{folder}/tasks/{task}/show_info', 'TaskController@showTaskInfo')->name('tasks.show_info');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
    Route::post('/folders/create', 'FolderController@create');

    Route::get('/mypage', 'UserController@showIndexPage')->name('users.index');
    Route::get('/mypage/edit', 'UserController@showEditForm')->name('users.edit');
    Route::post('/mypage/edit', 'UserController@editUserProfile');

    Route::group(['middleware' => 'can:view,folder'], function() {
        Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');
        
        Route::get('/folders/{folder}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', 'TaskController@create');

        Route::get('/folders/{folder}/tasks/{task}/edit', 'TaskController@showEditForm')->name('tasks.edit');
        Route::post('/folders/{folder}/tasks/{task}/edit', 'TaskController@edit');

    });
});

Auth::routes();