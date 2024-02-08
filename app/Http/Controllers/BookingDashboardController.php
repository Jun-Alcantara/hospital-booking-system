<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingDashboardController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('status', '!=', Booking::COMPLETED)
            ->with('patient')
            ->orderBy('created_at', 'DESC')
            ->get();

        $bookingToday = Booking::where('status', Booking::APPROVED)
            ->where('booking_date', '>=', now()->format('Y-m-d 00:00'))
            ->where('booking_date', '<=', now()->format('Y-m-d 23:59:00'))
            ->count();
        
        $pendingBookings = Booking::where('status', Booking::PENDING)
            ->count();

        return inertia('Console/Dashboard', compact('bookings', 'bookingToday', 'pendingBookings'));
    }
}
