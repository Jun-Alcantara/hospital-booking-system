<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\BookingReceive;
use App\Notifications\BookingReceived;

class SendBookingReceiveNotification
{
    protected $booking;

    /**
     * Create the event listener.
     */
    public function __construct(BookingReceive $event)
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
        
        $patient->notify(new BookingReceived($booking));
    }
}
