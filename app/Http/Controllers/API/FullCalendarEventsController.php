<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingBlockedDates;

class FullCalendarEventsController extends Controller
{
    public function events()
    {
        $blockedDates = BookingBlockedDates::get();

        $bookings = Booking::selectRaw("count(*) as booking_count, DATE_FORMAT(booking_date, '%Y-%m-%d') as date")
            ->groupBy(DB::raw("DATE_FORMAT(booking_date, '%Y-%m-%d')"))
            ->get()
            ->map(function ($booking) use ($blockedDates) {
                $block = $blockedDates->where('date', $booking->date)
                    ->first();

                $title = $booking->booking_count . " patient/s";
                if ($block ) {
                  $title = "DATE BLOCK: " . $block->reason;
                }

                return [
                    'title' => $title,
                    'start' => $booking->date,
                    'display' => $block ? 'background' : 'auto',
                    'backgroundColor' => $block ? 'red' : '#7cb7ff'
                ];
            });

        $blockedDates->map(function ($date) {
            return [
                'title' => 'DATE BLOCKED: ' . $date->reason,
                'start' => $date->date,
                'allDay' => true,
                'display' => 'background',
                'classNames' => 'blocked-date'
            ];
        });

        return $events = $bookings->merge($blockedDates->map(function ($date) {
            return [
                'title' => 'DATE BLOCKED: ' . $date->reason,
                'start' => $date->date,
                'allDay' => true,
                'display' => 'background',
                'classNames' => 'blocked-date'
            ];
        }));

        return [
            [
              'title'  => '2 Bookings',
              'start'  => '2024-03-07 10:00:00',
            ],
            [
              'title'  => '5 Bookings',
              'start'  => '2024-03-07 12:00:00',
            ],
            [
              'title'  => '7 Bookings',
              'start'  => '2024-03-07 13:00:00',
            ],
            [
              'title'  => '9 Bookings',
              'start'  => '2024-03-07 14:00:00',
            ],
            [
               'title' => 'Date Blocked - Blocked because the whole team is on vacation. The security guards and cleaners will be in charge while the team is out ',
               'start' => '2024-03-08 00:00:00',
               'allDay' => true,
               'display' => 'background',
               'classNames' => 'blocked-date'
            ]
        ];
    }   
}
