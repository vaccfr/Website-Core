<?php

use Illuminate\Support\Facades\App;
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

// Redirect non-locale URL to localed
Route::get('/', function () {
    return redirect(app()->getLocale());
});

// Landing page routes
Route::group([
    'middleware' => 'setlocale',
    'prefix' => '{locale}',
], function() {
    Route::get('/', 'Landingpage\MainController@index')->name('landingpage.home');
    Route::get('/policies', 'Landingpage\MainController@policies')->name('landingpage.home.policies');

    // Authentication routes
    Route::get('/access', 'SSO\AuthController@login')->name('auth.login');
    Route::get('/authenticate', 'SSO\AuthController@validateLogin')->name('auth.authenticate');
    Route::get('/logout', 'SSO\AuthController@logout')->name('auth.logout');

    // Member dashboard routes with locales
    Route::group([
        'middleware' => 'auth:web',
        'prefix' => '/app',
    ], function() {
        Route::get('/', 'App\MainController@index')->name('app.index');

        Route::get('/user/settings', 'App\MainController@usersettings')->name('app.user.settings');
        Route::post('/user/settings/edit', 'App\MainController@usersettingsedit')->name('app.user.settings.edit');

        // ATC Routes
        Route::group([
            'prefix' => '/atc',
        ], function() {
            Route::get('/loas', 'ATC\ATCPagesController@loas')->name('app.atc.loas');

            Route::group(['prefix' => '/trainingcenter'], function() {
                Route::get('/dashboard', 'ATC\ATCTrainingController@index')->name('app.atc.training'); // ATC Training route
                Route::post('/submit-application', 'ATC\ATCTrainingController@mentoringRequest')->name('app.atc.training.mentoringRequest');
            });
            
            Route::group(['middleware' => 'ATC', 'prefix' => '/book/verified'], function() {
                Route::get('/mybookings', 'ATC\BookingController@MyBookingsPage')->name('app.atc.mybookings');
            });
        });

        // Staff Routes
        Route::group([
            'middleware' => 'STAFF',
            'prefix' => '/staff'
        ], function() {
            Route::group(['prefix' => '/admin', 'middleware' => 'ADMIN'], function() {
                Route::get('/', 'Staff\AdminController@index')->name('app.staff.admin');
                Route::get('/edit', 'Staff\AdminController@editUser')->name('app.staff.admin.edit');

                Route::post('/edit/details', 'Staff\AdminController@editUserFormDetails')->name('app.staff.admin.edit.details');
                Route::post('/edit/staffstatus', 'Staff\AdminController@editUserFormStaff')->name('app.staff.admin.edit.staffstatus');
            });
            Route::group(['prefix' => '/atc'], function() {
                Route::get('/all', 'Staff\ATCMentorController@allview')->name('app.staff.atc.all');

                Route::post('/all/take', 'Staff\ATCMentorController@takeTraining')->name('app.staff.atc.all.take');
            });
            Route::group(['prefix' => '/pilot'], function() {
                
            });
            Route::group(['prefix' => '/exec'], function() {
                
            });
            Route::group(['prefix' => '/events'], function() {
                
            });
        });

        // Authenticated POST routes
        // Post and Action Routes
        Route::group(['prefix' => '/do'], function() {
            Route::group(['prefix' => '/atc'], function() {
                Route::post('/booking/add', 'ATC\BookingController@book')->name('do.atc.booking.add');
                Route::get('/booking/add/validate', 'ATC\BookingController@validateBooking')->name('do.atc.booking.validate');
                Route::get('/booking/{unique_id}/delete', 'ATC\BookingController@deleteBooking')->name('do.atc.booking.delete');
                Route::get('/booking/del/validate', 'ATC\BookingController@validateDelete')->name('do.atc.bookingdel.validate');
            });
        });
    });

    // DEV ROUTES
    Route::get('/importAirports', 'ATC\AirportsController@retrieveFromJson');
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
