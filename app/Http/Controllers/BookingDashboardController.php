<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BookingDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $bookings = Booking::where('status', '!=', Booking::COMPLETED)
            ->with(['patient', 'clinic', 'department'])
            ->orderBy('created_at', 'DESC')
            ->filterByRole($user)
            ->get();

        $bookingToday = Booking::where('status', Booking::APPROVED)
            ->where('booking_date', '>=', now()->format('Y-m-d 00:00'))
            ->where('booking_date', '<=', now()->format('Y-m-d 23:59:00'))
            ->with(['patient'])
            ->get();
        
        $pendingBookings = Booking::where('status', Booking::FOR_ASSESSMENT)
            ->with(['patient'])
            ->get();

        return inertia('Console/Dashboard', compact('bookings', 'bookingToday', 'pendingBookings'));
    }
}
