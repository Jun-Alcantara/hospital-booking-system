<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\PatientHealthDeclarationForm;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApprovedBookingsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
    public function __construct(
        protected $from,
        protected $to
    ) { }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $dateRangeFrom = $this->from;
        $dateRangeTo = $this->to;

        return Booking::with(['patient'])
            ->with('approver')
            ->where('status', Booking::APPROVED)
            ->when(is_null($dateRangeFrom) && is_null($dateRangeTo), function ($q) use($dateRangeFrom, $dateRangeTo) {
                $q->where('booking_date', '>=', now()->format('Y-m-d 00:00:00'));
            })
            ->when(! is_null($dateRangeFrom) && ! is_null($dateRangeTo), function ($q) use($dateRangeFrom, $dateRangeTo) {
                $q->where('booking_date', '>=', $dateRangeFrom)
                    ->where('booking_date', '<=', $dateRangeTo);
            })
            ->get()
            ->map(function ($booking) {
                $patient = $booking->patient;
                
                $healthDec = PatientHealthDeclarationForm::whereBookingId($booking->id)
                    ->first();

                $birthdate = null;
                if ($healthDec) {
                    $birthdate = Carbon::parse($healthDec->dob)->format("Y-m-d");
                }

                $clinicDepartment = null;
                if ($booking->status == Booking::APPROVED) {
                    $clinic = $booking->clinic;
                    $department = $booking->department;

                    if ($clinic && $department) {
                        $clinicDepartment = "$clinic->name/$department->name";
                    }

                }

                return [
                    'Last Name' => $patient->lastname,
                    'First Name' => $patient->firstname,
                    'Middle Name' => $patient->middlename,
                    'Age' => $healthDec->age ?? 0,
                    'Gender' => $healthDec->gender ?? null,
                    'Birthdate' => $birthdate,
                    'Address' => $healthDec->address ?? null,
                    'Approved Booked Date' => Carbon::parse($booking->booking_date)->format('Y-m-d'),
                    'Clinic/Department' => $clinicDepartment,
                    'Approved By' => $booking->approver->name ?? null
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Last Name',
            'First Name',
            'Middle Name',
            'Age',
            'Gender',
            'Birthdate',
            'Address',
            'Approved Booked Date',
            'Clinic / Department'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
