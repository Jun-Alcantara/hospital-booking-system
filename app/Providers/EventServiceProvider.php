<?php

namespace App\Providers;

use App\Events\BookingApproved;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\BookingReceive;
use App\Listeners\SendBookingApprovedNotification;
use App\Listeners\SendBookingReceiveNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        BookingReceive::class => [
            SendBookingReceiveNotification::class
        ],
        BookingApproved::class => [
            SendBookingApprovedNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
