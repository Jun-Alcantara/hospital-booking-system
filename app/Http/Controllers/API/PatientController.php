<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function searchEmail(Request $request)
    {
        $patient = Patient::whereEmail($request->email)->first();
        $pendingBooking = null;

        if ($patient) {
            $pendingBooking = Booking::wherePatientId($patient->id)
                ->whereStatus(Booking::PENDING)
                ->where('booking_date', '>', now()->format('Y-m-d'))
                ->first();
        }   

        return response()->json([
            'patient' => $patient,
            'pendingBooking' => $pendingBooking
        ]);
    }
}
