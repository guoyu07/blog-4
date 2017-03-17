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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('add_articles', 'ArticleController@create');
Route::get('post_articles', 'ArticleController@store');
Route::get('edit_articles/{id}', 'ArticleController@edit');
Route::get('article/{id}', 'ArticleController@show');
Route::get('post_comment', 'CommentController@store');
Route::get('up_articles/{id}', 'ArticleController@update');
Route::post('del_articles', 'ArticleController@destroy');
Route::post('del_comment', 'CommentController@destroy');