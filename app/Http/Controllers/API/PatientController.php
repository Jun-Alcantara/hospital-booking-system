<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function searchEmail(Request $request)
    {
        return Patient::whereEmail($request->email)->first();
    }
}
