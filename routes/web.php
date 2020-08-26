<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/posts', 'PostController@index')->name('posts.index');

Route::get('/posts/{post}', 'PostController@show')->name('posts.show')->where('post', '[0-9]+');
Route::get('/posts/create', 'PostController@create')->name('posts.create');
Route::post('/posts', 'PostController@store')->name('posts.store');
//
//Route::group(
//	['middleware' => ['role:writer']],
//	function () {
//		Route::get('/posts/create', 'PostController@create')->name('posts.create');
//		Route::post('/posts', 'PostController@store')->name('posts.store');
//	}
//);

Route::get('/home', 'HomeController@index')->name('home');
