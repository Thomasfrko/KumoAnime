<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'AnimeController@show');

Route::post('/delete', 'AnimeController@deleteAnime');

Route::post('/changeTag/{tag}', 'AnimeController@changeTag');

Route::get('/add', function() {
    return view('add');
});

Route::get('/settings', function() {
    return view('settings', [
        'content' => 'Hello'
    ]);
});

Route::get('/settings/{setting}', function($setting) {
    return view('settings', [
        'content' => $setting
    ]);
});

Route::post('/search', 'AnimeController@searchAnime');

Route::post('/add', 'AnimeController@addAnime');

Route::get('/watch/{anime}', 'AnimeController@watch');

Route::post('/update', 'AnimeController@update');
