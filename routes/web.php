<?php

use App\Models\Photo;
use App\User;

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
    return view('welcome');
});

Route::get('/albums', 'AlbumsController@index')->name('albums');
Route::delete('/albums/{id}', 'AlbumsController@delete')->where('id', '[0-9]+');
Route::get('/albums/create', 'AlbumsController@create')->name('album.create');
Route::get('/albums/{id}/edit', 'AlbumsController@edit');
Route::get('/albums/{id}', 'AlbumsController@show');
Route::patch('/albums/{id}', 'AlbumsController@store');
Route::post('/albums', 'AlbumsController@save')->name('album.save');

Route::get('/photos', function () {
    return Photo::All();
});

Route::get('/users', function () {
    return User::All();
});
