<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprovedBookingsExport;
use Illuminate\Http\Request;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Clinic;
use App\Models\ClinicDepartment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function reports()
    {
        return inertia('Console/Reports');
    }

    public function downloadPatientDatabase(Request $request)
    {
        $currentDate = now()->format('Y-m-d');
        $filename = "patient-database-$currentDate.xlsx";
        
        return Excel::download(new ApprovedBookingsExport($request->from, $request->to), $filename);
    }

    public function printableHealthDeclaration(Booking $booking)
    { 
        $healthDeclarationForm = $booking->healthDeclarationForm->sortByDesc('id')->first();

        if ($healthDeclarationForm) {
            $healthDeclarationForm->questions = json_decode($healthDeclarationForm->questions);
        }

        return inertia('Console/Printable/HealthDeclaration', compact('healthDeclarationForm'));
    }

    public function downloadDailyCensus(Request $request)
    {
        $data['clinic'] = Clinic::find($request->clinic);
        $data['department'] = ClinicDepartment::find($request->department);
        $data['date'] = Carbon::parse($request->date);

        $data['patients'] = $patients = collect(DB::select("
            SELECT *
            FROM patients p
            LEFT JOIN (
                SELECT patient_id, MAX(id) AS latest_booking_id
                FROM bookings
                GROUP BY patient_id
            ) latest_bookings ON p.id = latest_bookings.patient_id
            INNER JOIN patient_health_declaration_forms dc ON dc.booking_id = latest_booking_id
            INNER JOIN bookings b ON b.id = latest_bookings.latest_booking_id
            WHERE clinic_id = ?
            AND clinic_department_id = ?
            AND DATE_FORMAT(booking_date, '%Y-%m-%d') = ?
        ", [$request->clinic, $request->department, $request->date]));

        // return $patients->where('age', '>=', 25)
        //         ->where('age', '<=', 30)
        //         ->where('gender', 'male')
        //         ->count();

        $data['ageBracket'] = [
            '< 1' => [0,1],
            '1-4' => [1,4],
            '5-9' => [5,9],
            '10-14' => [10,14],
            '15-18' => [15,18],
            '19' => [19,19],
            '20-24' => [20,24],
            '25-29' => [25,29],
            '30-35' => [30,34],
            '36-39' => [35,39],
            '40-44' => [40,44],
            '45-49' => [45,49],
            '50-54' => [50,54],
            '55-59' => [55,59],
            '60-64' => [60,64],
            '65-69' => [65,69],
            '>70' => [70,100]
        ];

        $pdf = Pdf::loadView('pdf-templates.daily-census', $data);
        $pdf->setPaper('a4');
        return $pdf->download('invoice.pdf');
    }
}
