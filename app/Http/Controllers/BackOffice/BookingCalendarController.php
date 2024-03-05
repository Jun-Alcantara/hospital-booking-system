<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Models\BookingBlockedDates;

class BookingCalendarController extends Controller
{
    public function index()
    {
        $blockedDates = BookingBlockedDates::get();

        $bookings = Booking::selectRaw("count(*) as booking_count, DATE_FORMAT(booking_date, '%Y-%m-%d') as date")
            ->groupBy(DB::raw("DATE_FORMAT(booking_date, '%Y-%m-%d')"))
            ->get()
            ->map(function ($booking) use ($blockedDates) {
                $block = $blockedDates->where('date', $booking->date)
                    ->first();

                return [
                    'title' => $block ? 'BLOCKED' : "$booking->booking_count patient/s",
                    'start' => $booking->date,
                    'end' => $booking->date,
                    'display' => $block ? 'background' : 'list-item',
                    'backgroundColor' => $block ? 'red' : 'white'
                ];
            });

        $blockedDates->map(function ($date) {
            return [
                'title' => 'BLOCKED',
                'start' => $date->date,
                'end' => $date->date,
                'display' => 'background',
                'backgroundColor' => 'red'
            ];
        });

        $events = $bookings->merge($blockedDates->map(function ($date) {
            return [
                'title' => 'BLOCKED',
                'start' => $date->date,
                'end' => $date->date,
                'display' => 'background',
                'backgroundColor' => 'red',
                'reason' => $date->reason
            ];
        }));

        return inertia('Console/BookingCalendar/Index', compact('events'));
    }
}
