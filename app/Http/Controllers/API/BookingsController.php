<?php

namespace App\Http\Controllers\API;

use App\Events\DateBlocked;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingBlockedDates;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

        $bookings = Booking::whereBetween('booking_date', [$request->date . " 00:00:00", $request->date . " 23:59:59"])
            ->get();

        foreach ($bookings as $booking) {
            $token = Str::random(30);
            $booking->reschedule_token = $token;
            $booking->save();
        }

        $date = Carbon::parse($request->date)->format('Y-m-d');

        BookingBlockedDates::UpdateOrCreate([
            'date' => $date
        ], [
            'date' => $date,
            'reason' => $request->reason
        ]);

        event(new DateBlocked($bookings));

        return back()
            ->with('notification.success', 'Date has been blocked');
    }

    public function searchBooking(Request $request)
    {
        $searchKey = "%$request->q%";

        return Booking::with('patient')
            ->whereHas('patient', function ($q) use ($searchKey) {
                $q->whereRaw("(email LIKE ?)", [$searchKey]);
            })->get();
    }
}
