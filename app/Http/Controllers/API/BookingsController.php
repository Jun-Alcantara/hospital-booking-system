<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingBlockedDates;
use Carbon\Carbon;

class BookingsController extends Controller
{
    public function bookings(Request $request)
    {
        return Booking::whereBetween('booking_date', [$request->date . " 00:00:00", $request->date . " 23:59:59"])
            ->with('patient')
            ->get();
    }

    public function blockDate(Request $request)
    {
        Booking::whereBetween('booking_date', [$request->date . " 00:00:00", $request->date . " 23:59:59"])
            ->update([
                'status' => Booking::FOR_RESCHEDULING
            ]);

        $date = Carbon::parse($request->date)->format('Y-m-d');

        BookingBlockedDates::UpdateOrCreate([
            'date' => $date
        ], [
            'date' => $date,
            'reason' => $request->reason
        ]);

        return back()
            ->with('notification.success', 'Date has been blocked');
    }
}
