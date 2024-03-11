<?php

namespace App\Http\Controllers\BackOffice;

use App\Events\BookingReceive;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Clinic;
use App\Notifications\BookingReceived;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function show(Booking $booking)
    {
        $patient = $booking->patient;
        $booking->status_name = $booking->status_name;
        $healthDeclarationForm = $booking->healthDeclarationForm;

        if ($healthDeclarationForm) {
            $healthDeclarationForm->questions = json_decode($healthDeclarationForm->questions);
        }

        $booking->load(['clinic', 'department']);

        $clinics = Clinic::all();

        return inertia('Console/BookingDetails', compact('booking', 'patient', 'healthDeclarationForm', 'clinics'));
    }

    public function approve(Request $request, Booking $booking)
    {
        $booking->clinic_id = $request->clinic;
        $booking->clinic_department_id = $request->department;
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
        // BookingReceived
        event(new BookingReceive($booking));
        // return $booking->patient->notify(new BookingReceived($booking));
    }
}
