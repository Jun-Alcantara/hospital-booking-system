<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingFormController extends Controller
{
    public function index()
    {
        return inertia('BookingForm');
    }
}
