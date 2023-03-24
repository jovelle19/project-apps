<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('layouts.main');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/create', 'App\Http\Controllers\ArticleController@store');
Route::get('/articles', 'App\Http\Controllers\ArticleController@show');
Route::get('/delete', 'App\Http\Controllers\ArticleController@delete');
Route::get('/like-article', 'App\Http\Controllers\ArticleController@likeArticle');
Route::get('/unlike-article', 'App\Http\Controllers\ArticleController@unlikeArticle');
