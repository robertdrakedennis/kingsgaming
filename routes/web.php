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

Route::get('/', 'IndexController@index');

Route::get('/discord', 'RedirectController@discordRedirect');
Route::get('/server', 'RedirectController@serverRedirect');
Route::get('/steam', 'RedirectController@steamRedirect');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// login routes

Route::get('logout', 'Auth\LoginController@logout')->name('logout'); // or use the default post method if you prefer

Route::get('login/steam', 'Auth\SteamLoginController@login')->name('login.steam');
Route::get('auth/steam', 'Auth\SteamLoginController@handle')->name('auth.steam');