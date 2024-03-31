<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprovedBookingsExport;
use Illuminate\Http\Request;

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
}
