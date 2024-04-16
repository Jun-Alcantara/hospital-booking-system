<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function clinics()
    {
        return Clinic::all();
    }

    public function show(Clinic $clinic)
    {
        return $clinic->departments;
    }
}
