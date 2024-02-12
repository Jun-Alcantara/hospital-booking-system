<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Notifications\BookingReceive;

class BookingController extends Controller
{
    public function show(Booking $booking)
    {
        $patient = $booking->patient;
        $booking->status_name = $booking->status_name;
        $healthDeclarationForm = $booking->healthDeclarationForm;

        $healthDeclarationForm->questions = json_decode($healthDeclarationForm->questions);

        return inertia('Console/BookingDetails', compact('booking', 'patient', 'healthDeclarationForm'));
    }

    public function approve(Booking $booking)
    {
        $booking->status = Booking::APPROVED;
        $booking->save();

        return back()
            ->with('notification.success', 'Booking status has been updated');
    }

    public function cancel(Booking $booking)
    {
        $booking->status = Booking::CANCELED;
        $booking->save();

        return back()
            ->with('notification.success', 'Booking status has been updated');
    }

    public function sendNotification(Booking $booking)
    {
        return $booking->patient->notify(new BookingReceive);
    }
}
