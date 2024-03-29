<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Patient;
use App\Models\PatientHealthDeclarationForm;
use Carbon\Carbon;
use App\Models\Booking;

class PatientDatabaseExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $booking = Booking::where('booking_date', '>=', now()->format('Y-m-d'))
            ->where('status', Booking::APPROVED)
            ->with(['patient',
                'healthDeclarationForm' => function ($builder) {
                    $builder->latest()
                        ->first();
                }
            ])
            ->get();

        dd($booking->toArray());
    }
}
