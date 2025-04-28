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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', "AdminController@login")->name("login");
Route::get('/logout', "AdminController@logout")->name("logout");
Route::post('/login', "AdminController@submitLogin")->name("submit.login");

Route::group(['middleware' => ['admin-auth']], function () {
    Route::group(["prefix" => "dashboard", "as" => "dashboard."], function () {
        Route::get('/', "DashboardController@index")->name("index");
        Route::post('/message', "DashboardController@sendMessage")->name("sendMessage");
    });
});
