<?php

namespace App\Http\Controllers\BackOffice;

use App\Events\BookingApproved;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Models\BookingSettings;
use App\Models\BookingBlockedDates;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function show(Booking $booking)
    {
        $patient = $booking->patient;
        $booking->status_name = $booking->status_name;
        $healthDeclarationForm = $booking->healthDeclarationForm->sortByDesc('id')->first();

        if ($healthDeclarationForm) {
            $healthDeclarationForm->questions = json_decode($healthDeclarationForm->questions);
        }

        $booking->load(['clinic', 'department']);

        $clinics = Clinic::all();

        return inertia('Console/BookingDetails', compact('booking', 'patient', 'healthDeclarationForm', 'clinics'));
    }

    public function approve(Request $request, Booking $booking)
    {
        $booking->clinic_id = $request->clinic;
        $booking->clinic_department_id = $request->department;
        $booking->status = Booking::APPROVED;
        $booking->save();

        event(new BookingApproved($booking));

        return back()
            ->with('notification.success', 'Booking status has been updated');
    }

    public function cancel(Booking $booking)
    {
        $booking->status = Booking::CANCELED;
        $booking->save();

        return back()
            ->with('notification.success', 'Booking status has been updated');
    }

    public function rescheduleForm(Booking $booking)
    {
        $patient = $booking->patient;
        $settings = BookingSettings::find(1);

        $fullyBookSlots = Booking::selectRaw('DATE_FORMAT(booking_date, "%Y-%m-%d") as date')
            ->selectRaw('COUNT(*) as booking_count')
            ->groupBy(DB::raw('DATE_FORMAT(booking_date, "%Y-%m-%d")'))
            ->havingRaw('COUNT(*) >= ?', [$settings->max_booking_per_day ?? 250])
            ->get()
            ->pluck('date');

        $blockDates = BookingBlockedDates::get(['date']);

        $disabledDates = $fullyBookSlots->merge($blockDates->pluck('date'));

        $clinics = Clinic::all();

        return inertia('Console/BookingRescheduleForm', compact('booking', 'patient', 'disabledDates', 'clinics'));
    }

    public function reschedule(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'clinic' => 'required',
            'department' => 'required',
            'newDate' => 'required',
        ]);

        $booking->clinic_id = $validated['clinic'];
        $booking->clinic_department_id = $validated['department'];
        $booking->booking_date = Carbon::parse($validated['newDate'])->format('Y-m-d');
        $booking->status = Booking::APPROVED;
        $booking->save();

        event(new BookingApproved($booking));

        return redirect("/console/booking/$booking->reference_number")
            ->with('notification.success', 'Booking has been approved');
    }

    public function rescheduleRequest(Request $request, Booking $booking)
    {
        $newDate = Carbon::parse($request->newDate . " " . $request->time . ":00:00")
            ->format('Y-m-d H:i:s');

        $booking->booking_date = $newDate;
        $booking->status = Booking::PENDING;
        $booking->save();

        return redirect('booking/status/' . $booking->reference_number);
    }

    public function sendNotification(Booking $booking)
    {
        // BookingReceived
        event(new BookingApproved($booking));
        // return $booking->patient->notify(new BookingReceived($booking));
    }
}
