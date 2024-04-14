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

        return DB::raw();

        $ageBracket = [

        ];

        $pdf = Pdf::loadView('pdf-templates.daily-census', $data);
        $pdf->setPaper('a4');
        return $pdf->download('invoice.pdf');
    }
}
