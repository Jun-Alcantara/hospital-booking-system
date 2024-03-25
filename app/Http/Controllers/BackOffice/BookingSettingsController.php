<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingSettings;
use Illuminate\Support\Facades\Storage;

class BookingSettingsController extends Controller
{
    public function showSettings()
    {
        $settings = BookingSettings::find(1);

        return inertia('Console/BookingSettings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $settingsData = [
            'max_booking_per_day' => $request->maxBookingPerDay,
            'visit_start' => $request->visitStart,
            'visit_end' => $request->visitEnd
        ];

        if ($request->hasFile('opdSchedule') && ! is_null($request->opdSchedule)) {
            $image = $request->file('opdSchedule');
            $extension = $image->extension();
            $uniqueFilename = now()->format('FdY');
            $path = "images/opdSchedule-$uniqueFilename.$extension";

            Storage::put($path, file_get_contents($request->file('opdSchedule')));

            $settingsData['opd_schedule_img'] = $path;
        }

        BookingSettings::updateOrCreate([
            'id' => 1
        ], $settingsData);

        return back()->with('notification.success', 'Settings updated');
    }

    public function manageDates()
    {
        return inertia('Console/BookingCalendar/Index');
    }
}
