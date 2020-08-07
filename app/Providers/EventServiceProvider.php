<?php

namespace App\Providers;

use App\Events\EventDeleteATCBooking;
use App\Events\Authentication\EventLogin;
use App\Events\Authentication\EventLogout;
use App\Events\EventExceptionLog;
use App\Events\EventNewATCBooking;
use App\Events\EventNewInternalMessage;
use App\Listeners\ListenDeleteATCBooking;
use App\Listeners\Authentication\ListenLogin;
use App\Listeners\Authentication\ListenLogout;
use App\Listeners\ListenExceptionLog;
use App\Listeners\ListenNewATCBooking;
use App\Listeners\ListenNewInternalMessage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        EventExceptionLog::class => [
            ListenExceptionLog::class,
        ],
        EventNewATCBooking::class => [
            ListenNewATCBooking::class,
        ],
        EventDeleteATCBooking::class => [
            ListenDeleteATCBooking::class,
        ],
        EventNewInternalMessage::class => [
            ListenNewInternalMessage::class,
        ],
        EventLogin::class => [
            ListenLogin::class,
        ],
        EventLogout::class => [
            ListenLogout::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
