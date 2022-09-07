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

Route::get('/','PostController@index');

//Route::resources('post','PostController');


Route::get('post/','PostController@index')->name('post.index');

Route::get('post/create','PostController@create')->name('post.create');
Route::get('post/show/{id}','PostController@show')->name('post.show');
Route::get('post/edit/{id}','PostController@edit')->name('post.edit');

Route::post('post/store','PostController@store')->name('post.store');
Route::patch('post/update/{id}','PostController@update')->name('post.update');
Route::delete('post/{id}','PostController@destroy')->name('post.destroy');



Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home');
