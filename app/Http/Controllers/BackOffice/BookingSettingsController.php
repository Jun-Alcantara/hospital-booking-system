<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingSettings;
use App\Models\BookingBlockedDates;

class BookingSettingsController extends Controller
{
    public function showSettings()
    {
        $settings = BookingSettings::find(1);

        return inertia('Console/BookingSettings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        BookingSettings::updateOrCreate([
            'id' => 1
        ], [
            'max_booking_per_day' => $request->maxBookingPerDay,
            'visit_start' => $request->visitStart,
            'visit_end' => $request->visitEnd
        ]);

        return back()->with('notification.success', 'Settings updated');

        // if (isset($request->blockDates) && is_array($request->blockDates)) {
        //     foreach ($request->blockDates as $date) {
        //         BookingBlockedDates::create();
        //     }
        // }
    }
}