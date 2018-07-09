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
Route::get('/staff', 'StaffController@index')->name('staff');


// login routes
Route::get('logout', 'Auth\LoginController@logout')->name('logout'); // or use the default post method if you prefer

Route::get('login/steam', 'Auth\SteamLoginController@login')->name('login.steam');
Route::get('auth/steam', 'Auth\SteamLoginController@handle')->name('auth.steam');

Route::get('/theme', function () {
    return view('front.theme');
});

Route::get('/forums/profile/{steamid}', 'ProfileController@show')->name('profile');

//Route::get('/test', 'TestPermissionsController@index');


Route::group(['middleware' => ['role:Administrator']], function () {
    Route::resource('/admin', 'AdminPanelController');
    Route::post('/admin/{id}/banFromEverything', 'AdminPanelController@banFromEverything');
    Route::post('/admin/{id}/banFromPosting', 'AdminPanelController@banFromPosting');
    Route::post('/admin/{id}/unbanFromEverything', 'AdminPanelController@unbanFromEverything');
    Route::post('/admin/{id}/unbanFromPosting', 'AdminPanelController@unbanFromPosting');
    Route::post('/admin/{id}/setRoleAdministrator', 'AdminPanelController@setRoleAdministrator');
    Route::post('/admin/{id}/setRoleUser', 'AdminPanelController@setRoleUser');
});

Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});