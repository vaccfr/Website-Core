<?php

namespace App\Providers;

use App\Events\EventDeleteATCBooking;
use App\Events\EventLogin;
use App\Events\EventNewATCBooking;
use App\Events\EventNewInternalMessage;
use App\Listeners\ListenDeleteATCBooking;
use App\Listeners\ListenLogin;
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
