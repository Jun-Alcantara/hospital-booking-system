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
use Illuminate\Support\Facades\Auth;

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

        $booking->load(['clinic', 'department', 'assignedBy', 'cancelledBy', 'approver']);

        $clinicDepartmentApprovedBookings = Booking::where('bookings.booking_date', '>=', now()->format('Y-m-d 00:00:00'))  
            ->where('bookings.clinic_id', $booking->clinic_id)
            ->where('bookings.clinic_department_id', $booking->clinic_department_id)
            ->where('bookings.status', Booking::APPROVED)
            ->count();

        $clinics = Clinic::all();

        return inertia('Console/BookingDetails', compact('booking', 'patient', 'healthDeclarationForm', 'clinics', 'clinicDepartmentApprovedBookings'));
    }

    public function approve(Request $request, Booking $booking)
    {
        abort_if(! $this->userCanApprove(), 403, "You're not allowed to do this action");

        $booking->status = Booking::APPROVED;
        $booking->approved_by = Auth::user()->id;
        $booking->save();

        event(new BookingApproved($booking));

        return back()
            ->with('notification.success', 'Booking status has been updated');
    }

    public function cancel(Booking $booking)
    {
        $booking->status = Booking::CANCELED;
        $booking->cancelled_by = Auth::user()->id;
        $booking->save();

        return back()
            ->with('notification.success', 'Booking status has been updated');
    }

    public function rescheduleForm(Booking $booking)
    {
        abort_if(! $this->userCanReschedule(), 403, "You're not allowed to do this action");

        $patient = $booking->patient;
        $settings = BookingSettings::find(1);
        $booking->load(['clinic', 'department']);

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
        abort_if(! $this->userCanReschedule(), 403, "You're not allowed to do this action");

        $validated = $request->validate([
            'newDate' => 'required',
        ]);

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
        $booking->status = Booking::FOR_ASSESSMENT;
        $booking->save();

        return redirect('booking/status/' . $booking->reference_number);
    }

    public function assign(Booking $booking, Request $request)
    {
        $validated = $request->validate([
            'clinic' => 'required',
            'department' => 'required'
        ]);

        $booking->clinic_id = $validated['clinic'];
        $booking->clinic_department_id = $validated['department'];
        $booking->status = Booking::FOR_APPROVAL;
        $booking->assigned_by = Auth::user()->id;
        $booking->save();
        
        return back()
            ->with('notification.success', 'Booking details updated and waiting for approval');
    }

    public function returnToTriage(Booking $booking, Request $request)
    {
        $booking->clinic_id = null;
        $booking->clinic_department_id = null;
        $booking->status = Booking::FOR_ASSESSMENT;
        $booking->save();

        return redirect()
            ->route('console.dashboard')
            ->with('notification.success', 'Booking details updated');
    }

    public function sendNotification(Booking $booking)
    {
        // BookingReceived
        event(new BookingApproved($booking));
        // return $booking->patient->notify(new BookingReceived($booking));
    }
}
