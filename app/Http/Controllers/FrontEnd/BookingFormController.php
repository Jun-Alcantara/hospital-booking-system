<?php

namespace App\Http\Controllers\FrontEnd;

use App\Events\BookingReceive;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingFormRequest;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Booking;

class BookingFormController extends Controller
{
    public function submit(BookingFormRequest $request)
    {
        $patient = Patient::updateOrCreate([
            'email' => $request->email
        ], [
            'email' => $request->email,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
        ]);

        $booking = Booking::create([
            'reference_number' => Booking::newReferenceNumber($patient->id),
            'patient_id' => $patient->id,
            'booking_date' => Carbon::parse("{$request->date} {$request->time}:00:00")
                ->format('Y-m-d H:i:s'),
            'note' => $request->note
        ]);

        // event(new BookingReceive($booking));

        return redirect()->route('booking.status', $booking);
    }

    public function showStatus(Booking $booking)
    {
        $patient = $booking->patient;
        $booking->booking_date_formatted = $booking->booking_date->format('F d, Y h:i A');
        $booking->status_name = $booking->status_name;

        return inertia('BookingStatus', compact('booking', 'patient'));
    }
}
