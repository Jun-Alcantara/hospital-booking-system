<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingDashboardController extends Controller
{
    public function index()
    {
        return inertia('Console/Dashboard');
    }
}
