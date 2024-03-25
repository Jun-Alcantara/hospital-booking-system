<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingSettings;
use Illuminate\Support\Facades\DB;
use App\Models\BookingBlockedDates;

class BookingFormControllerX extends Controller
{
    public function index()
    {
        $settings = BookingSettings::find(1);

        $fullyBookSlots = Booking::selectRaw('DATE_FORMAT(booking_date, "%Y-%m-%d") as date')
            ->selectRaw('COUNT(*) as booking_count')
            ->groupBy(DB::raw('DATE_FORMAT(booking_date, "%Y-%m-%d")'))
            ->havingRaw('COUNT(*) >= ?', [$settings->max_booking_per_day ?? 250])
            ->get()
            ->pluck('date');

        $blockDates = BookingBlockedDates::get(['date']);

        $disabledDates = $fullyBookSlots->merge($blockDates->pluck('date'));

        return inertia('BookingForm', compact('disabledDates', 'settings'));
    }
}
