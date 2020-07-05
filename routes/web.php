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

// Landing page routes
Route::get('/', 'Landingpage\MainController@index')->name('landingpage.home');
Route::get('/atctraining', 'Landingpage\MainController@atctraining')->name('landingpage.atc.training');
Route::get('/atcrequest', 'Landingpage\MainController@atcrequest')->name('landingpage.atc.request');
Route::get('/pilottraining', 'Landingpage\MainController@pilottraining')->name('landingpage.pilot.training');

Auth::routes();

Route::group(['middleware' => 'auth:web', 'prefix' => '/app'], function() {
    Route::get('/', 'App\MainController@index')->name('home');
});

// Route::get('/home', 'HomeController@index')->name('home');
