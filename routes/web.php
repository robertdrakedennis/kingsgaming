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

Route::get('/', 'IndexController@index')->name('home');

Route::get('/discord', 'RedirectController@discordRedirect')->name('discord');
Route::get('/server', 'RedirectController@serverRedirect')->name('server');
Route::get('/steam', 'RedirectController@steamRedirect')->name('steam');
Route::get('/leaderboards', 'LeaderboardController@index')->name('leaderboard');


// login routes
Route::get('logout', 'Auth\LoginController@logout')->name('logout'); // or use the default post method if you prefer

Route::get('login/steam', 'Auth\SteamLoginController@login')->name('login.steam');
Route::get('auth/steam', 'Auth\SteamLoginController@handle')->name('auth.steam');