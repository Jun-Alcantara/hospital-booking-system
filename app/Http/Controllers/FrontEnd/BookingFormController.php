<?php

namespace App\Http\Controllers\FrontEnd;

use App\Events\BookingReceive;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingFormRequest;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Booking;
use App\Models\BookingSettings;
use Illuminate\Http\Request;

class BookingFormController extends Controller
{
    public function submit(BookingFormRequest $request)
    {
        $patient = Patient::updateOrCreate([
            'email' => $request->email
        ], [
            'email' => $request->email,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
        ]);

        $booking = Booking::create([
            'reference_number' => Booking::newReferenceNumber($patient->id),
            'patient_id' => $patient->id,
            'booking_date' => Carbon::parse("{$request->date} {$request->time}:00:00")
                ->format('Y-m-d H:i:s'),
            'note' => $request->note
        ]);

        // event(new BookingReceive($booking));

        return redirect()->route('booking.status', $booking);
    }

    public function showHealthDeclarationForm(Booking $booking)
    {
        return inertia('HealthDeclarationForm');
    }

    public function showStatus(Booking $booking)
    {
        $patient = $booking->patient;
        $booking->booking_date_formatted = $booking->booking_date->format('F d, Y h:i A');
        $booking->status_name = $booking->status_name;

        return inertia('BookingStatus', compact('booking', 'patient'));
    }

    public function availableTimeSlots(Request $request)
    {
        $settings = BookingSettings::find(1);

        $duration = $settings->visit_end - $settings->visit_start;
        $maxBookingPerSlot = round($settings->max_booking_per_day / $duration);

        $fullyBookedSlots = Booking::selectRaw("DATE_FORMAT(booking_date, '%Y-%m-%d %H:00') AS booking_hour")
            ->selectRaw('COUNT(*) AS total_bookings')
            ->where('booking_date', 'LIKE', "%$request->date%")
            ->groupByRaw("DATE_FORMAT(booking_date, '%Y-%m-%d %H:00')")
            ->havingRaw('COUNT(*) >= ?', [$maxBookingPerSlot])
            ->get()
            ->map(fn ($slot) => intval(Carbon::parse($slot->booking_hour)->format('H')));

        $result = [];

        for ($i = $settings->visit_start; $i <= $settings->visit_end; $i++) {
            $ampm = 'AM';
            $hour = $i;

            if ($i >= 13) {
                $ampm = 'PM';
                $hour = $hour - 12;
            }

            $availability = true;
            if (in_array($i, $fullyBookedSlots->toArray())) {
                $availability = false;
            }

            $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);

            $result[] = [
                'text' => "{$hour}:00 {$ampm}",
                'id' => $i,
                'is_available' => $availability
            ];
        }

        return $result;
    }
}
