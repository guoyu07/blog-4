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

Route::get('/', 'ArticleController@home');

Auth::routes();

Route::get('article/{id}', 'ArticleController@show');

Route::group(['middleware'=>'login'], function() {
    Route::get('myarticles', 'ArticleController@index');
    Route::get('/home', 'ArticleController@userHome');
    Route::get('add_articles', 'ArticleController@create');
    Route::post('post_articles', 'ArticleController@store');
    Route::post('edit_articles/{id}', 'ArticleController@edit');
    Route::post('post_comment', 'CommentController@store');
    Route::get('up_articles/{id}', 'ArticleController@update');
    Route::post('del_articles', 'ArticleController@destroy');
    Route::post('del_comment', 'CommentController@destroy');
});