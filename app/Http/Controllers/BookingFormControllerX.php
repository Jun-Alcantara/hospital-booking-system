<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingSettings;

class BookingFormControllerX extends Controller
{
    public function index()
    {
        $settings = BookingSettings::find(1);

        $blockDates = Booking::selectRaw('DATE_FORMAT(booking_date, "%Y-%m-%d") as date')
            ->groupBy('booking_date')
            ->havingRaw("COUNT(*) >= ?", [$settings->max_booking_per_day ?? 250])
            ->get()
            ->pluck('date');

        return inertia('BookingForm', compact('blockDates'));
    }
}
