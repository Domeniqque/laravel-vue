<?php

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('tasks/all', 'TaskController@getAll');

Route::resource('tasks', 'TaskController');
Route::resource('users', 'UserController');

