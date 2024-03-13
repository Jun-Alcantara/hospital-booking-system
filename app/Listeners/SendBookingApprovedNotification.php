<?php

namespace App\Listeners;

use App\Events\BookingApproved;
use App\Notifications\BookingApproved as BookingApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookingApprovedNotification
{
    protected $booking;

    /**
     * Create the event listener.
     */
    public function __construct(BookingApproved $event)
    {
        $this->booking = $event->booking;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $booking = $event->booking;
        $patient = $booking->patient;
        
        $patient->notify(new BookingApprovedNotification($booking));
    }
}
