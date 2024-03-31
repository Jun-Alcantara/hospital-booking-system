<?php

namespace App\Listeners;

use App\Events\DateBlocked;
use App\Models\Patient;
use App\Notifications\BookedDateBlockedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyBlockedDates
{
    protected $bookings;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        // $this->bookings = $event->bookings;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        foreach ($event->bookings as $booking) {
            $patient = $booking->patient;

            $patient->notify(new BookedDateBlockedNotification($booking));
        }
    }
}
