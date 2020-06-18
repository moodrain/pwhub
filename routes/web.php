<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'user.login')->name('login');
Route::view('register', 'user.register');
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');


Route::middleware(['auth'])->group(function() {

    Route::get('/', 'IndexController@index');
    Route::post('logout', 'UserController@logout');

    Route::get('account/list', 'AccountController@list');
    Route::any('account/edit', 'AccountController@edit');
    Route::post('account/destroy', 'AccountController@destroy');

    Route::get('application/list', 'ApplicationController@list');
    Route::any('application/edit', 'ApplicationController@edit');
    Route::post('application/destroy', 'ApplicationController@destroy');

});