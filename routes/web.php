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
    return view('welcome');
});

// Route::get('threads', 'ThreadsController@index');
// Route::get('threads/create', 'ThreadsController@create');
// Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
// Route::post('threads', 'ThreadsController@store');
// Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('/threads', 'ThreadsController@store');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::post('/threads/{channel}/{thread}/subscribe', 'ThreadsSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscribe', 'ThreadsSubscriptionController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::delete('/replies/{reply}', 'RepliesController@destroy');
Route::patch('/replies/{reply}', 'RepliesController@update');

Route::get('/profiles/{user}', 'ProfilesController@show');

Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy')->middleware('auth');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
