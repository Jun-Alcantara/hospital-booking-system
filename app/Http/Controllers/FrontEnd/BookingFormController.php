<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingFormRequest;

class BookingFormController extends Controller
{
    public function submit(BookingFormRequest $request)
    {
        return $request->all();
    }
}
