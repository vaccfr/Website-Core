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

// Policies
Route::group(['prefix' => '/policies'], function() {
    Route::get('/privacy', function() {
        return view('policies.privacy');
    })->name('policy.privacy');
});

// Auth::routes();

// Authentication routes
Route::get('/login', 'SSO\AuthController@login')->name('auth.login');
Route::get('/authenticate', 'SSO\AuthController@validateLogin')->name('auth.authenticate');
Route::get('/logout', 'SSO\AuthController@logout')->name('auth.logout');

// Member dashboard routes
Route::group(['middleware' => 'auth:web', 'prefix' => '/app'], function() {
    Route::get('/', 'App\MainController@index')->name('app.index');
});

// Route::get('/home', 'HomeController@index')->name('home');
