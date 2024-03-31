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
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Booking::with(['patient'])
            ->where('status', Booking::APPROVED)
            ->where('booking_date', '>=', now()->format('Y-m-d 00:00:00'))
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
                    'Clinic/Department' => $clinicDepartment
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
