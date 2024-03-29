<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprovedBookingsExport;

class ReportsController extends Controller
{
    public function reports()
    {
        return inertia('Console/Reports');
    }

    public function downloadPatientDatabase()
    {
        $currentDate = now()->format('Y-m-d');
        $filename = "patient-database-$currentDate.xlsx";
        
        return Excel::download(new ApprovedBookingsExport, $filename);
    }
}
