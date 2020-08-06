<?php

use App\Mail\NewBookingMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Spatie\CalendarLinks\Link;

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
    Route::get('/events', 'Landingpage\MainController@events')->name('landingpage.home.events');
    Route::get('/feedback', 'Landingpage\MainController@feedback')->name('landingpage.home.feedback');
    Route::get('/contact', 'Landingpage\MainController@contact')->name('landingpage.home.contact');
    Route::post('/contact/submit', 'Landingpage\MainController@contactForm')->middleware('auth:web')->name('landingpage.home.contact.submit');
    Route::get('/requestatc', 'Landingpage\MainController@reqatc')->name('landingpage.home.reqatc');
    Route::post('/requestatc/submit', 'Landingpage\MainController@reqatcForm')->middleware('auth:web')->name('landingpage.home.reqatc.submit');
    Route::get('/policies', 'Landingpage\MainController@policies')->name('landingpage.home.policies');

    // Authentication routes
    Route::get('/access/{redirflag}', 'SSO\AuthController@login')->name('auth.login');
    Route::get('/authenticate', 'SSO\AuthController@validateLogin')->name('auth.authenticate');
    Route::get('/validateLogin/{code}', 'SSO\AuthController@computeLogin')->name('auth.redirect');
    Route::get('/logout', 'SSO\AuthController@logout')->name('auth.logout');

    // Member dashboard routes with locales
    Route::group([
        'middleware' => 'auth:web',
        'prefix' => '/app',
    ], function() {
        Route::group(['middleware' => 'InboxFetcher'], function() {
            Route::get('/', 'App\MainController@index')->name('app.index');

            Route::get('/general/stafforg', 'App\MainController@staffOrg')->name('app.general.stafforg');

            Route::group(['prefix' => '/user'], function() {
                Route::get('/', function () {
                    return redirect()->route('app.user.settings', app()->getLocale());
                });
                Route::get('/settings', 'App\MainController@usersettings')->name('app.user.settings');
                Route::post('/settings/edit', 'App\MainController@usersettingsedit')->name('app.user.settings.edit');
                Route::post('/settings/editemail', 'App\MainController@userEmailPrefEdit')->name('app.user.settings.editemail');
            });

            Route::group([
                'prefix' => 'pigeon-voyageur',
                'middleware' => 'CanSendMail',
            ], function() {
                Route::get('/', function () {
                    return redirect()->route('app.inmsg.inbox', app()->getLocale());
                });
                Route::get('/inbox', 'App\InternalMessagingController@inbox')->name('app.inmsg.inbox');
                Route::get('/read', 'App\InternalMessagingController@read')->name('app.inmsg.read');
                Route::get('/sent', 'App\InternalMessagingController@sent')->name('app.inmsg.sent');
                Route::get('/archive', 'App\InternalMessagingController@archive')->name('app.inmsg.archive');
                Route::get('/trash', 'App\InternalMessagingController@trash')->name('app.inmsg.trash');

                Route::post('/send', 'App\InternalMessagingController@sendMessage')->name('app.inmsg.send');
                Route::post('/reply', 'App\InternalMessagingController@sendReply')->name('app.inmsg.reply');
                Route::post('/archive', 'App\InternalMessagingController@archiveMessage')->name('app.inmsg.archive');
                Route::post('/delete', 'App\InternalMessagingController@deleteMessage')->name('app.inmsg.delete');
            });

            // ATC Routes
            Route::group([
                'prefix' => '/atc',
            ], function() {
                Route::get('/', function () {
                    return redirect()->route('app.index', app()->getLocale());
                });
                Route::get('/roster', 'ATC\ATCPagesController@atcRoster')->name('app.atc.roster');
                Route::get('/loas', 'ATC\ATCPagesController@loas')->name('app.atc.loas');

                Route::group(['prefix' => '/trainingcenter'], function() {
                    Route::get('/', function () {
                        return redirect()->route('app.atc.training', app()->getLocale());
                    });
                    Route::get('/dashboard', 'ATC\ATCTrainingController@index')->name('app.atc.training'); // ATC Training route
                    
                    Route::post('/submit-application', 'ATC\ATCTrainingController@mentoringRequest')->name('app.atc.training.mentoringRequest');
                    Route::post('/acceptsession', 'ATC\ATCTrainingController@acceptSession')->name('app.atc.training.acceptsession');
                    Route::post('/cancelsession', 'ATC\ATCTrainingController@cancelSession')->name('app.atc.training.cancelsession');
                    Route::post('/requestsession', 'ATC\ATCTrainingController@requestSession')->name('app.atc.training.requestsession');
                });
                
                Route::get('/book/all', 'ATC\BookingController@allBookings')->name('app.atc.allbookings');
                Route::group(['middleware' => 'ATC', 'prefix' => '/book/verified'], function() {
                    Route::get('/mybookings', 'ATC\BookingController@MyBookingsPage')->name('app.atc.mybookings');
                });
            });

            // Staff Routes
            Route::group([
                'middleware' => 'STAFF',
                'prefix' => '/staff'
            ], function() {
                Route::get('/', function () {
                    return redirect()->route('app.index', app()->getLocale());
                });
                Route::group(['prefix' => '/admin', 'middleware' => 'EXECSTAFF'], function() {
                    Route::get('/', 'Staff\AdminController@index')->name('app.staff.admin');
                    Route::get('/edit', 'Staff\AdminController@editUser')->name('app.staff.admin.edit');
                    Route::get('/atcadmin', 'Staff\AdminController@atcAdmin')->name('app.staff.atcadmin');

                    Route::post('/edit/details', 'Staff\AdminController@editUserFormDetails')->name('app.staff.admin.edit.details');
                    Route::post('/edit/atcmentor', 'Staff\AdminController@editUserAtcMentor')->name('app.staff.admin.edit.atcmentor');
                    Route::post('/edit/staffstatus', 'Staff\AdminController@editUserFormStaff')->name('app.staff.admin.edit.staffstatus');
                    Route::post('/atcadmin/approval', 'Staff\AdminController@approveSpecialPosition')->name('app.staff.atcadmin.approval');
                    Route::post('/atcadmin/delsolo', 'Staff\AdminController@delSolo')->name('app.staff.atcadmin.delsolo');
                    Route::post('/atcadmin/delapplication', 'Staff\AdminController@delApplication')->name('app.staff.atcadmin.delapplication');
                });
                Route::group(['prefix' => '/atc', 'middleware' => 'ATCMENTOR'], function() {
                    Route::get('/all', 'Staff\ATCMentorController@allview')->name('app.staff.atc.all');
                    Route::get('/mystudents', 'Staff\ATCMentorController@myStudents')->name('app.staff.atc.mine');

                    Route::post('/all/take', 'Staff\ATCMentorController@takeTraining')->name('app.staff.atc.all.take');
                    Route::post('/mystudents/booksession', 'Staff\ATCMentorController@bookSession')->name('app.staff.atc.mine.booksession');
                    Route::post('/mystudents/acceptsession', 'Staff\ATCMentorController@acceptSession')->name('app.staff.atc.mine.acceptsession');
                    Route::post('/mystudents/cancelsession', 'Staff\ATCMentorController@cancelSession')->name('app.staff.atc.mine.cancelsession');
                    Route::post('/mystudents/completesession', 'Staff\ATCMentorController@completeSession')->name('app.staff.atc.mine.completesession');
                    Route::post('/mystudents/sessionreport', 'Staff\ATCMentorController@writeSessionReport')->name('app.staff.atc.mine.sessionreport');
                    Route::post('/mystudents/progress', 'Staff\ATCMentorController@editProgress')->name('app.staff.atc.mine.progress');
                    Route::post('/mystudents/soloAdd', 'Staff\ATCMentorController@makeSolo')->name('app.staff.atc.mine.soloadd');
                    Route::post('/mystudents/soloDel', 'Staff\ATCMentorController@delSolo')->name('app.staff.atc.mine.solodel');
                    Route::post('/mystudents/terminate', 'Staff\ATCMentorController@terminate')->name('app.staff.atc.mine.terminate');
                });
                Route::group(['prefix' => '/pilot'], function() {
                    
                });
                Route::group(['prefix' => '/events', 'middleware' => 'EVENTSSTAFF'], function() {
                    Route::get('/', 'Staff\EventsManagerController@dashboard')->name('app.staff.events.dashboard');

                    Route::post('/newevent', 'Staff\EventsManagerController@newEvent')->name('app.staff.events.newevent');
                    Route::post('/delevent', 'Staff\EventsManagerController@delEvent')->name('app.staff.events.delevent');
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
    });

    // DEV ROUTES
    Route::group(['prefix' => '/devactions', 'middleware' => 'ADMIN'], function() {
        Route::get('/importAirports', 'ATC\AirportsController@retrieveFromJson');
        Route::get('/email', function() {
            $from = DateTime::createFromFormat('d.m.Y H:i', '30.07.2020 04:00');
            $to = DateTime::createFromFormat('d.m.Y H:i', '30.07.2020 05:00');
            $link = Link::create('LFFF_CTR - VatFrance ATC', $from, $to)
                            ->description('VatFrance ATC Booking on LFFF_CTR - 30.07.2020 @ 04:00 - 05:00');
            
            $calendarLinks = [
                'ics' => $link->ics(),
                'google' => $link->google(),
            ];

            $data = [
                'position' => 'LFFF_CTR',
                'date' => '30.07.2020',
                'time' => '04:00 - 05:00',
                'start_time' => '04:00',
                'end_time' => '05:00',
            ];

            return new NewBookingMail(auth()->user(), $data, $calendarLinks);
        });
    });
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
