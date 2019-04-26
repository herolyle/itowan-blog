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


Route::get('/', 'UserController@index');
Route::get('/user', 'UserController@superAdmin');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/register', 'Auth\RegisterController@index');
Route::get('/login', 'Auth\LoginController@index');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/post', 'PostController@index');
Route::get('/post/edit/{id?}', 'PostController@edit');


Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\RegisterController@register');

Route::middleware(['log'])->group(function() {
    Route::post('/post/createOrUpdate', 'PostController@createOrUpdate');
    Route::post('/post/delete', 'PostController@delete');
});



