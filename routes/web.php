<?php

use App\Models\Photo;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {return view('welcome');});
    Route::get('/home', 'AlbumsController@index')->name('albums');
    Route::get('/albums', 'AlbumsController@index')->name('albums');
    Route::delete('/albums/{album}', 'AlbumsController@delete')->where('album', '[0-9]+');
    Route::get('/albums/create', 'AlbumsController@create')->name('album.create');
    Route::get('/albums/{id}/edit', 'AlbumsController@edit');
    Route::get('/albums/{id}', 'AlbumsController@show');
    Route::patch('/albums/{id}', 'AlbumsController@store');
    Route::post('/albums', 'AlbumsController@save')->name('album.save');
    Route::get('/albums/{album}/images', 'AlbumsController@getImages')->name('album.getimages')->where('album', '[0-9]+');
});

Route::get('/photos', function () {
    return Photo::All();
});

Route::get('/users', function () {
    return User::All();
});

// querybuilder quesry complessa con leftjoin e where null
Route::get('usersnoalbums', function () {
    return DB::table('users as u')
        ->leftjoin('albums as a', 'a.user_id', 'u.id')
        ->select('name', 'email', 'u.id')
        ->whereNull('a.album_name')
        ->whereRaw()
        ->get();
});

// images mappa le route con la risorsa attraverso i metodi del controller
Route::resource('photos', 'PhotosController');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
