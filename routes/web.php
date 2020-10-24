<?php

use App\Mail\Mentoring\NewAtcSessionMail;
use App\Mail\Mentoring\NewRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use RestCord\DiscordClient;

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

Route::get('/discord', function() {
    return redirect('https://discord.gg/f279VCy');
})->name('discord.invite');
Route::get('/pilotbrief', function() {
    return redirect()->route('landingpage.pilot.charts', app()->getLocale());
})->name('redirect.pilotbrief');
Route::get('/lib', function() {
    return redirect('https://library.vatsim.fr');
})->name('redirect.library');
Route::get('/fb/{cid}', 'Landingpage\MainController@feedbackRedir')->name('redirect.feedback');
Route::get('/roster', function() {
    return redirect()->route('app.atc.roster', 'en');
})->name('redirect.roster');

// Landing page routes
Route::group([
    'middleware' => 'setlocale',
    'prefix' => '{locale}',
], function() {
    Route::get('/', 'Landingpage\MainController@index')->name('landingpage.home');
    Route::group(['prefix' => '/pilot'], function() {
        Route::get('/', function() {return redirect()->route('landingpage.pilot.charts', app()->getLocale());});
        Route::get('/charts', 'Landingpage\PilotChartsController@index')->name('landingpage.pilot.charts');
        Route::post('/charts', 'Landingpage\PilotChartsController@fetch')->name('landingpage.pilot.charts.fetch');
        Route::get('/training', 'Landingpage\MainController@trainingPilote')->name('landingpage.pilot.training');
    });
    Route::group(['prefix' => '/atc'], function() {
        Route::get('/', function() {return redirect()->route('landingpage.atc.training', app()->getLocale());});
        Route::get('/training', 'Landingpage\MainController@trainingATC')->name('landingpage.atc.training');
        Route::get('/visiting', 'Landingpage\MainController@visitingATC')->name('landingpage.atc.visiting');
    });
    Route::get('/feedback', 'Landingpage\MainController@feedback')->name('landingpage.home.feedback');
    Route::post('/feedback/submit', 'Landingpage\MainController@feedbackForm')->middleware('auth:web')->name('landingpage.home.feedback.submit');
    Route::get('/contact', 'Landingpage\MainController@contact')->name('landingpage.home.contact');
    Route::post('/contact/submit', 'Landingpage\MainController@contactForm')->middleware('auth:web')->name('landingpage.home.contact.submit');
    Route::get('/requestatc', 'Landingpage\MainController@reqatc')->name('landingpage.home.reqatc');
    Route::post('/requestatc/submit', 'Landingpage\MainController@reqatcForm')->middleware('auth:web')->name('landingpage.home.reqatc.submit');
    Route::get('/policies', 'Landingpage\MainController@policies')->name('landingpage.home.policies');

    // Authentication routes
    Route::get('/access/{redirflag}', 'SSO\AuthController@login')->name('auth.login');
    Route::get('/authenticate', 'SSO\AuthController@validateLogin')->name('auth.authenticate');
    Route::get('/validateLogin/{code}/{ip}', 'SSO\AuthController@computeLogin')->name('auth.redirect');
    Route::get('/logout', 'SSO\AuthController@logout')->name('auth.logout');

    // Discord OAUTH Redirect
    Route::get('/discord-validate', 'App\DiscordController@redirectCode')->name('discord.redirect');

    // Member dashboard routes with locales
    Route::group([
        'middleware' => 'auth:web',
        'prefix' => '/app',
    ], function() {
        Route::group(['middleware' => 'BANNEDUSER'], function() {
            Route::group(['middleware' => 'InboxFetcher'], function() {
                Route::get('/', 'App\MainController@index')->name('app.index');
                Route::get('/calendar', 'App\MainController@calendarPage')->name('app.calendar');
    
                Route::group(['prefix' => 'general'], function() {
                    Route::get('/', function () {
                        return redirect()->route('app.general.stafforg', app()->getLocale());
                    });
                    Route::get('/org', 'App\MainController@staffOrg')->name('app.general.stafforg');
                    Route::get('/stats', 'App\MainController@statsPage')->name('app.general.stats');
                });
    
                Route::group(['prefix' => '/user'], function() {
                    Route::get('/link-discord', 'App\DiscordController@link')->name('app.user.linkdiscord')->middleware('BANNEDUSER');
                    Route::get('/unlink-discord', 'App\DiscordController@unlink')->name('app.user.unlinkdiscord')->middleware('BANNEDUSER');
                    Route::get('/settings', 'App\MainController@usersettings')->name('app.user.settings');
                    Route::post('/gdpr-download', 'DataHandlers\GDPRController@download')->name('app.user.dl-gdpr');
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
                    
                    Route::group([
                        'prefix' => '/resources',
                    ], function() {
                        Route::get('/', function () {
                            return redirect()->route('app.atc.tools', app()->getLocale());
                        });
                        Route::get('/loas', 'ATC\ATCPagesController@loas')->name('app.atc.loas');
                        Route::get('/tools', 'ATC\ATCPagesController@tools')->name('app.atc.tools');
                        Route::post('/toolsgen', 'ATC\ATCPagesController@toolsGenAtis')->name('app.atc.tools.atisgen');
                    });
    
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
    
                    Route::group([
                        'prefix' => '/cofrance',
                        'middleware' => 'BETATESTER',
                    ], function() {
                        Route::get('/dashboard', 'CoFrance\CoFranceController@dashboard')->name('app.atc.cofrance.dashboard');
                        Route::post('/newtoken', 'CoFrance\CoFranceController@createToken')->name('app.atc.cofrance.newtoken');
                        Route::post('/storeconfig', 'CoFrance\CoFranceController@storeConfig')->name('app.atc.cofrance.storeconfig');
                    });
                });
    
                // Pilot Routes
                Route::group([
                    'prefix' => '/pilot'
                ], function() {
                    Route::get('/', function () {
                        return redirect()->route('app.index', app()->getLocale());
                    });
                    Route::group(['prefix' => '/trainingcenter'], function() {
                        Route::get('/', function () {
                            return redirect()->route('app.pilot.training', app()->getLocale());
                        });
                        Route::get('/dashboard', 'Pilot\PilotTrainingController@index')->name('app.pilot.training'); // Pilot Training route
                        
                        Route::post('/submit-application', 'Pilot\PilotTrainingController@mentoringRequest')->name('app.pilot.training.mentoringRequest');
                        Route::post('/acceptsession', 'Pilot\PilotTrainingController@acceptSession')->name('app.pilot.training.acceptsession');
                        Route::post('/cancelsession', 'Pilot\PilotTrainingController@cancelSession')->name('app.pilot.training.cancelsession');
                        Route::post('/requestsession', 'Pilot\PilotTrainingController@requestSession')->name('app.pilot.training.requestsession');
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
                        Route::get('/contact-feedback-manager', 'Staff\AdminController@contactFeedbackManager')->name('app.staff.cofbmanager');
                        Route::post('/contact-feedback-manager/respond', 'Staff\AdminController@contactFeedbackManagerRespond')->name('app.staff.cofbmanager.corespond');
                        Route::get('/faqmaker', 'Staff\AdminController@faqMaker')->name('app.staff.faqmaker');
                        Route::post('/atcadmin/validate', 'Staff\AdminController@validateATCReq')->name('app.staff.atcadmin.v');
                        Route::post('/atcadmin/refuse', 'Staff\AdminController@refuseATCReq')->name('app.staff.atcadmin.r');
    
                        Route::post('/edit/details', 'Staff\AdminController@editUserFormDetails')->name('app.staff.admin.edit.details');
                        Route::post('/edit/atcmentor', 'Staff\AdminController@editUserAtcMentor')->name('app.staff.admin.edit.atcmentor');
                        Route::post('/edit/pilotmentor', 'Staff\AdminController@editUserPilotmentor')->name('app.staff.admin.edit.pilotmentor');
                        Route::post('/edit/staffstatus', 'Staff\AdminController@editUserFormStaff')->name('app.staff.admin.edit.staffstatus');
                        Route::post('/atcadmin/approval', 'Staff\AdminController@approveSpecialPosition')->name('app.staff.atcadmin.approval');
                        Route::post('/atcadmin/delsolo', 'Staff\AdminController@delSolo')->name('app.staff.atcadmin.delsolo');
                        Route::post('/atcadmin/delapplication', 'Staff\AdminController@delApplication')->name('app.staff.atcadmin.delapplication');
    
                        Route::post('/block', 'Staff\BanController@addBan')->name('app.staff.block.add');
                        Route::post('/unblock', 'Staff\BanController@removeBan')->name('app.staff.block.remove');
                    });
                    Route::group(['prefix' => '/atc', 'middleware' => 'ATCMENTOR'], function() {
                        Route::get('/', 'Staff\ATCMentorController@allview')->name('app.staff.atc.all');
                        Route::get('/mystudents', 'Staff\ATCMentorController@myStudents')->name('app.staff.atc.mine');
    
                        Route::post('/take', 'Staff\ATCMentorController@takeTraining')->name('app.staff.atc.all.take');
                        Route::post('/all/reject', 'Staff\ATCMentorController@rejectTraining')->name('app.staff.atc.all.reject');
                        Route::post('/mystudents/booksession', 'Staff\ATCMentorController@bookSession')->name('app.staff.atc.mine.booksession');
                        Route::post('/mystudents/acceptsession', 'Staff\ATCMentorController@acceptSession')->name('app.staff.atc.mine.acceptsession');
                        Route::post('/mystudents/cancelsession', 'Staff\ATCMentorController@cancelSession')->name('app.staff.atc.mine.cancelsession');
                        Route::post('/mystudents/completesession', 'Staff\ATCMentorController@completeSession')->name('app.staff.atc.mine.completesession');
                        Route::post('/mystudents/sessionreport', 'Staff\ATCMentorController@writeSessionReport')->name('app.staff.atc.mine.sessionreport');
                        Route::post('/mystudents/progress', 'Staff\ATCMentorController@editProgress')->name('app.staff.atc.mine.progress');
                        Route::post('/mystudents/soloAdd', 'Staff\ATCMentorController@makeSolo')->name('app.staff.atc.mine.soloadd');
                        Route::post('/mystudents/soloDel', 'Staff\ATCMentorController@delSolo')->name('app.staff.atc.mine.solodel');
                        Route::post('/mystudents/modapt', 'Staff\ATCMentorController@modifyAirport')->name('app.staff.atc.mine.modapt');
                        Route::post('/mystudents/terminate', 'Staff\ATCMentorController@terminate')->name('app.staff.atc.mine.terminate');
                    });
                    Route::group(['prefix' => '/pilot'], function() {
                        Route::get('/', 'Staff\PilotMentorController@allview')->name('app.staff.pilot.all');
                        Route::get('/mystudents', 'Staff\PilotMentorController@myStudents')->name('app.staff.pilot.mine');
    
                        Route::post('/take', 'Staff\PilotMentorController@takeTraining')->name('app.staff.pilot.all.take');
                        Route::post('/reject', 'Staff\PilotMentorController@rejectTraining')->name('app.staff.pilot.all.reject');
                        Route::post('/mystudents/booksession', 'Staff\PilotMentorController@bookSession')->name('app.staff.pilot.mine.booksession');
                        Route::post('/mystudents/acceptsession', 'Staff\PilotMentorController@acceptSession')->name('app.staff.pilot.mine.acceptsession');
                        Route::post('/mystudents/cancelsession', 'Staff\PilotMentorController@cancelSession')->name('app.staff.pilot.mine.cancelsession');
                        Route::post('/mystudents/completesession', 'Staff\PilotMentorController@completeSession')->name('app.staff.pilot.mine.completesession');
                        Route::post('/mystudents/sessionreport', 'Staff\PilotMentorController@writeSessionReport')->name('app.staff.pilot.mine.sessionreport');
                        Route::post('/mystudents/progress', 'Staff\PilotMentorController@editProgress')->name('app.staff.pilot.mine.progress');
                        Route::post('/mystudents/modapt', 'Staff\PilotMentorController@modifyTraining')->name('app.staff.pilot.mine.modapt');
                        Route::post('/mystudents/terminate', 'Staff\PilotMentorController@terminate')->name('app.staff.pilot.mine.terminate');
                    });
                    Route::group(['prefix' => '/news-events', 'middleware' => 'EVENTSSTAFF'], function() {
                        Route::get('/', function() {
                            return redirect()->route('app.staff.events.dashboard', app()->getLocale());
                        });
                        Route::get('/events', 'Staff\EventsManagerController@dashboard')->name('app.staff.events.dashboard');
                        Route::post('/newevent', 'Staff\EventsManagerController@newEvent')->name('app.staff.events.newevent');
                        Route::post('/delevent', 'Staff\EventsManagerController@delEvent')->name('app.staff.events.delevent');
                        Route::post('/editevent', 'Staff\EventsManagerController@editEvent')->name('app.staff.events.editevent');
                        Route::post('/editevent-img', 'Staff\EventsManagerController@editImage')->name('app.staff.events.editimg');
                        Route::post('/discordpub', 'Staff\EventsManagerController@publishDiscord')->name('app.staff.events.dpub');
                        Route::post('/discorddel', 'Staff\EventsManagerController@deleteDiscord')->name('app.staff.events.ddel');
    
                        Route::get('/news', 'Staff\NewsController@dashboard')->name('app.staff.news.dashboard');
                        Route::post('/news-add', 'Staff\NewsController@newItem')->name('app.staff.news.add');
                        Route::post('/news-edit', 'Staff\NewsController@editItem')->name('app.staff.news.edit');
                        Route::post('/news-delete', 'Staff\NewsController@deleteItem')->name('app.staff.news.delete');
                        Route::post('/discord-pub', 'Staff\NewsController@publishDiscord')->name('app.staff.news.dpub');
                        Route::post('/discord-del', 'Staff\NewsController@deleteDiscord')->name('app.staff.news.ddel');
                    });
                    Route::group(['prefix' => 'webadmin', 'middleware' => 'ADMIN'], function() {
                        Route::get('/', 'Staff\WebadminController@dashboard')->name('app.staff.webadmin.dashboard');
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
    });

    // DEV ROUTES
    Route::group(['prefix' => '/devactions', 'middleware' => 'ADMIN'], function() {
        Route::get('/importAirports', 'ATC\AirportsController@retrieveFromJson');
        Route::get('/email', function(Request $request) {
            return new NewAtcSessionMail($request->user(), [
                'mentor_fname' => "Peter",
                'position' => 'LFFF_CTR',
                'date' => 'date_here',
                'time' => 'start - end',
            ]);
        });
        Route::get('/coord/{lon}/{lat}', function($locale, $lon, $lat) {
            $vertices_x = array(-7.50, 9, 10.1, -7.50);
            $vertices_y = array(51, 51, 40.1, 40.6);
            $point_polygon = count($vertices_x);
            $longitude_x = $lon;
            $latitude_y = $lat;
        });
    });
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
